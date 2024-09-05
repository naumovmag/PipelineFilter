<?php

declare(strict_types=1);

namespace PipelineFilter\Core\Traits;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;
use PipelineFilter\Core\Filters\FilterPipelineInterface;

/**
 * Trait HasPipelineFilter
 *
 * The trait must be used in the model in which pipeline filtering will occur
 *
 * @method static Builder pipelineFilter(array $filters, mixed $dto)
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
    public function scopePipelineFilter(Builder $builder, array $filters, mixed $dto): Builder
    {
        foreach ($filters as $filter) {
            $filterObject = new $filter();

            /** @var FilterPipelineInterface $filter */
            if ($filterObject instanceof FilterPipelineInterface) {
                $builder = $filterObject->apply($builder, $dto);
                continue;
            }

            throw new InvalidArgumentException(
                sprintf('Filter %s must implement FilterPipelineInterface.', get_class($filterObject))
            );
        }

        return $builder;
    }
}
