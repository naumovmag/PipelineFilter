<?php

declare(strict_types=1);

namespace App\Traits;

use App\Core\Filters\FilterPipelineInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait HasPipelineFilter
 *
 * The trait must be used in the model in which pipeline filtering will occur
 *
 * @method static Builder filter(array $filters, mixed $dto)
 */
trait HasPipelineFilter
{
    /**
     * This method applies an array of filters to the query builder.
     * Each filter must implement the FilterPipelineInterface.
     * DTO - arbitrary for versatility, declared in the filter itself in the annotation
     *
     * @param Builder $builder
     * @param array $filters
     * @param mixed $dto
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, array $filters, mixed $dto): Builder
    {
        foreach ($filters as $filter) {
            $filterObject = new $filter();
            /** @var FilterPipelineInterface $filter */
            if ($filterObject instanceof FilterPipelineInterface) {
                $builder = $filterObject->apply($builder, $dto);
            }
        }

        return $builder;
    }
}
