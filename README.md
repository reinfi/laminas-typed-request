Laminas request replacement to solve static code analysis issues. 

=======

1. [Installation](#installation)
2. [Configuration](#configuration)
3. [Differences](#differences)

### Installation

1. Install with Composer: `composer require reinfi/laminas-typed-request`.
2. Enable the module via config in `appliation.config.php` under `modules` key:

```php
    return [
        'modules' => [
            'Reinfi\TypedRequest',
            // other modules
        ],
    ];
```

