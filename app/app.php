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
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app['dao.categorie'] = $app->share(function ($app) {
    return new RIT\DAO\CategorieDAO($app['db']);
});

// Register services.
/*
$app['dao.link'] = $app->share(function ($app) {
    return new RIT\DAO\LinkDAO($app['db']);
});*/

$app['dao.link'] = $app->share(function ($app) {
    $linkDAO = new RIT\DAO\LinkDAO($app['db']);
    $linkDAO->setCategorieDAO($app['dao.categorie']);
    return $linkDAO;
});
