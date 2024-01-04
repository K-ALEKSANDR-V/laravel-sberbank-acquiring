# laravel-sberbank-acquiring
[![MIT license](https://img.shields.io/badge/License-MIT-blue.svg)](https://lbesson.mit-license.org/)

Пакет предоставляет вашему приложению функциональность для работы с платежами с использованием эквайринга от Сбербанка.
Возможности:
- Создание и хранение платежей
- Логирование операций по платежам

Перед использованием рекомендуется ознакомиться с документацией, предоставляемой Сбербанком.

## Требования
* PHP >= 7.2
* Laravel >= 5.8
* Расширения PHP: ext-json, ext-curl
* Реляционная БД

## Установка
Добавьте пакет в зависимости:
```
composer require K-ALEKSANDR-V/laravel-sberbank-acquiring
```

Опубликуйте файл настроек:
```
php artisan vendor:publish --provider="ALEKSANDR\SberbankAcquiring\Providers\AcquiringServiceProvider" --tag=config
```

Запустите миграции:
```
php artisan migrate
```

## Лицензия (License)
The MIT License (MIT). Please see [License File](https://github.com/K-ALEKSANDR-V/laravel-sberbank-acquiring/blob/main/LICENSE) for more information.
