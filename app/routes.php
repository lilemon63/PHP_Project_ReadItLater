<?php

$app->get('/index', function () use ($app) {

    $categories = $app['dao.categorie']->findAll();
    return $app['twig']
		->render('viewIndex.html.twig',array('categories' => $categories));
})->bind('home');


$app->get('/', function () use ($app) {

    $links = $app['dao.link']->findAll();
    return $app['twig']
		->render('viewMain.html.twig',array('links' => $links));
})->bind('links');


$app->get('/categorie/{id}', function ($id) use ($app) {
    $categorie = $app['dao.categorie']->find($id);
    $links = $app['dao.link']->findAllByCategorie($id);
    
    return $app['twig']->render('categorie.html.twig', array('categorie' => $categorie, 'links' => $links));
})->bind('categorie');

/*
$app->get('/info', function () use ($app) {
    return phpinfo();//'Hello '.$app->escape($name);
});


$app->get('/system/createDB', function () use ($app) {
	require(__DIR__ .'/../web/DB/createDB.php');
	//return phpinfo();//'Hello '.$app->escape($name);
	return "<br/>";
});


$app->get('/system/createTable', function () use ($app) {
	require(__DIR__ . '/../web/DB/createTable.php'); 

	//return phpinfo();//'Hello '.$app->escape($name);
	return "<br/>";
});
*/
