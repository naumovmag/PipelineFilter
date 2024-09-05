# Pipeline Filter Library

Library for using the pipeline data filtering pattern in models.

## Установка

Для установки библиотеки выполните следующую команду:

```bash
composer require naumov-adata/pipeline-filter
```

## Использование

После установки библиотеки вы можете использовать её в своих моделях. Вот пример того, как это сделать:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PipelineFilter\Core\Traits\HasPipelineFilter;

final class YourModel extends Model
{
    use HasPipelineFilter;

    // Другие методы и свойства модели
}
```

Пример фильтра
```php
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
```

Пример использования фильтров
```php
$dto = new YourDataTransferObject(); // Создайте ваш DTO

$results = YourModel::pipelineFilter([
    AccessFilter::class,
    WithCompaniesFilter::class,
    FavoriteAccessFilter::class,
], $dto)->get();
```

## Зависимости

Библиотека требует следующие зависимости:

- PHP версии `^8.0`

## Лицензия

Данная библиотека не имеет лицензии.
