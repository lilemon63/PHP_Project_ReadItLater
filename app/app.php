<?php
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider()); // app['db']
$app->register(new Silex\Provider\TwigServiceProvider(), array( // app['twig']
    'twig.path' => __DIR__.'/../views',
));

// Register services.
$app['dao.link'] = $app->share(function ($app) {
    return new RIT\DAO\LinkDAO($app['db']);
});
