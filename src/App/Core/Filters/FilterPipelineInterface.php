<?php

declare(strict_types=1);

namespace App\Core\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class FilterPipelineInterface
 */
interface FilterPipelineInterface
{
    /**
     * @param Builder $builder
     * @param mixed $dto
     *
     * @return Builder
     */
    public static function apply(Builder $builder, mixed $dto): Builder;
}
