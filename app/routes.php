<?php

$app->get('/categories', function () use ($app) {

    $categories = $app['dao.categorie']->findAll();
    
    return $app['twig']
		->render('viewIndex.html.twig',array('categories' => $categories));
})->bind('categories');


$app->get('/', function () use ($app) {

    $links = $app['dao.link']->findAllWithContent();
    $categories = $app['dao.categorie']->findAll();
    return $app['twig']
		->render('viewMain.html.twig',	array(
			'links' => $links,
			'categories' => $categories,
			'idCateg' => -1));
})->bind('home');



$app->get('/categorie/{id}', function ($id) use ($app) {
    $categorie = $app['dao.categorie']->find($id);
    $links = $app['dao.link']->findAllByCategorie($id);
    $categories = $app['dao.categorie']->findAll();
    
    return $app['twig']
		->render('viewMain.html.twig',	array(
			'links' => $links,
			'categories' => $categories,
			'idCateg' => $id));
    //return $app['twig']->render('categorie.html.twig', array('categorie' => $categorie, 'links' => $links));
})->bind('categorie');

$app->post('/link/add/{url}',function($url) use ($app) {
	$trueUrl = str_replace("_",".",$url);
	$trueUrl = str_replace('+','/',$trueUrl);
	
	return $app['dao.link']->addLink($trueUrl);
})->bind('addLink');



$app->get('/link/setContent/{id}',function($id) use ($app){
	
	$app['dao.link']->searchContent($id);
	
	return "osef\n";
	
})->bind('setContent');

$app->get('/link/content/{id}',function($id) use ($app){
	$link = $app['dao.link']->find($id);
	return $app['twig']->render('content.html.twig', array( 'link' => $link));
})->bind('content');

$app->post('/categ/add/{name}',function($name) use ($app) {
	
	return $app['dao.categorie']->addCategorie($name);
})->bind('addCateg');

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
