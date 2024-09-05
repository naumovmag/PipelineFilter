# Pipeline Filter Library

Library for using the pipeline data filtering pattern in models.

## Установка

Для установки библиотеки выполните следующую команду:

```bash
composer require naumov/pipeline-filter
```

## Использование

После установки библиотеки вы можете использовать её в своих моделях. Вот пример того, как это сделать:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Naumov\PipelineFilter\Traits\HasPipelineFilter;

final class YourModel extends Model
{
    use HasPipelineFilter;

    // Другие методы и свойства модели
}

// Пример использования фильтров
$dto = new YourDataTransferObject(); // Создайте ваш DTO

$results = YourModel::filter([
    AccessFilter::class,
    WithCompaniesFilter::class,
    FavoriteAccessFilter::class,
], $dto)->get();
```

## Зависимости

Библиотека требует следующие зависимости:

- `illuminate/database` версии `^11.22`
- PHP версии `^8.0`

## Лицензия

Данная библиотека не имеет лицензии.
