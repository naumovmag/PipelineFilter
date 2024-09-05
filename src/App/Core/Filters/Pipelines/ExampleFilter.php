<?php

declare(strict_types=1);

namespace App\Core\Filters\Pipelines;

use App\Core\Filters\FilterPipelineInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
