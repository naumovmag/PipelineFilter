<?php

declare(strict_types=1);

namespace PipelineFilter\Core\Filters\Pipelines;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use PipelineFilter\Core\Filters\FilterPipelineInterface;

/**
 * Class ExampleFilter
 */
class ExampleFilter implements FilterPipelineInterface
{
    /**
     * @param Builder $builder
     * @param mixed $dto
     *
     * @return Builder
     */
    public static function apply(Builder $builder, mixed $dto): Builder
    {
        /** @var Model|Builder $builder */
        return true
            ? $builder->where('name', $dto->name)
            : $builder;
    }
}
