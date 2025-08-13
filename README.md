# groton-school/session-cookie-middleware

Implementation of PSR-15 middleware to manage session cookies with CHIPS partition support

[![Latest Version](https://img.shields.io/packagist/v/groton-school/session-cookie-middleware.svg)](https://packagist.org/packages/groton-school/session-cookie-middleware)

## Install

composer require groton-school/session-cookie-middleware

## Use

In `app/dependencies.php`:

```php
use DI;
use GrotonSchool\Session\Session;
use Odan\Session\SessionInterface;
use Odan\Session\SessionManagerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([

        // ...other dependencies...

        Session::class => function(ContainerInterface $container) {
            return new Session([
                'name' => 'session-cookie',
                'lifetime' => 86400,
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'partitioned' => false
            ]);
        },
        SessionInterface::class => DI\get(Session::class),
        SessionManagerInterface::class => DI\get(Session::class)
    ])
}
```

Either in `app/routes.php`:

```php
use GrotonSchool\Session\SessionCookieMiddleware;

// ...

$app->get('/route/that/needs/session', SomeAction::class)
  ->add(SessionCookieMiddleware::class);
```

...or in `app/middleware.php`:

```php
use GrotonSchool\Session\SessionCookieMiddleware;

// ...

$app->add(SessionCookieMiddleware::class);
```
