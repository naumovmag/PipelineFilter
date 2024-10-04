<?php

declare(strict_types=1);

namespace PipelineFilter\Core\Builder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Class CachedModelBuilder
 */
final class CachedModelBuilder extends Builder
{
    /**
     * Request caching time (in seconds)
     */
    private const CACHING_SECONDS = 600;

    /**
     * Custom get method with caching functionality.
     *
     * This method attempts to retrieve the results of the query from the cache.
     * If the cache does not have the results, it will execute the query, cache the results if they are not empty, and return them.
     *
     * @param array|string $columns Columns to be selected in the query
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getWithCache($columns = ['*']): Collection
    {
        $cacheKey = $this->getCacheKey();

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $get = parent::get($columns);

        if ($get->isNotEmpty()) {
            return Cache::remember($cacheKey, now()->addSeconds(self::CACHING_SECONDS), function () use ($get, $columns) {
                return $get;
            });
        }

        return $get;
    }

    /**
     * Custom paginate method with caching functionality.
     *
     * This method attempts to retrieve the paginated results of the query from the cache.
     * If the cache does not have the results, it will execute the query, cache the results if they are not empty, and return them.
     *
     * @param int $perPage Number of results per page
     * @param array|string $columns Columns to be selected in the query
     * @param string $pageName The name of the pagination parameter
     * @param int|null $page The current page number
     *
     */
    public function paginateWithCache($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $cacheKey = $this->getCacheKey() . "-page-$page-$perPage";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $paginate = parent::paginate($perPage, $columns, $pageName, $page);

        if ($paginate->isNotEmpty()) {
            return Cache::remember($cacheKey, now()->addSeconds(self::CACHING_SECONDS), function () use ($perPage, $columns, $pageName, $page) {
                return parent::paginate($perPage, $columns, $pageName, $page);
            });
        }

        return $paginate;
    }

    /**
     * Generate a cache key for the current query.
     *
     * This method generates a unique cache key by combining the class name and an MD5 hash
     * of the SQL query and its bindings. This ensures that identical queries will share the same cache key.
     *
     * @return string
     */
    private function getCacheKey(): string
    {
        return sprintf(
            "%s-%s",
            CachedModelBuilder::class,
            md5($this->toSql() . serialize($this->getBindings()))
        );
    }
}
