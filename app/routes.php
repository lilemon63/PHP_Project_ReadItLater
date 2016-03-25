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

$app->get('/archived', function () use ($app) {

    $links = $app['dao.link']->findAllArchived();
    $categories = $app['dao.categorie']->findAll();
    return $app['twig']
		->render('viewMain.html.twig',	array(
			'links' => $links,
			'categories' => $categories,
			'idCateg' => -1,
			'archived' => 1
			));
})->bind('archived');



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

$app->get('/link/add/{url}',function($url) use ($app) {
	$trueUrl = str_replace(",",".",$url);
	$trueUrl = str_replace('+','/',$trueUrl);
	
	
	
	//return $app['dao.link']->addLink($trueUrl);
	$app['dao.link']->addLink($trueUrl);
	
	$app['dao.link']->searchContent($app['dao.link']->getIdByUrl($trueUrl));
	return "0";
})->bind('addLink');



$app->get('/link/setContent/{id}',function($id) use ($app){
	
	$app['dao.link']->searchContent($id);
	
	return "0";
	
})->bind('setContent');

$app->get('/link/content/{id}',function($id) use ($app){
	$link = $app['dao.link']->find($id);
	return $app['twig']->render('content.html.twig', array( 'link' => $link));
})->bind('content');

$app->get('/categ/add/{name}',function($name) use ($app) {
	
	return $app['dao.categorie']->addCategorie($name);
})->bind('addCateg');


$app->get('/categ/swap/{idLink}/{idCateg}',function($idLink,$idCateg) use ($app) {
	return $app['dao.categorie']->changeCategorie($idLink,$idCateg);
})->bind('changeCateg');


$app->get('/categ/remove/{idCateg}',function($idCateg) use ($app) {
	return $app['dao.categorie']->removeCategorie($idCateg);
})->bind('removeCateg');

$app->get('/link/archive/{id}',function($id) use ($app) {
	return $app['dao.link']->archiveLink($id);
})->bind('archiveLink');

$app->get('/link/remove/{id}',function($id) use ($app) {
	return $app['dao.link']->removeLink($id);
})->bind('removeLink');


$app->get('/system/createDB', function () use ($app) {
	require(__DIR__ .'/../web/fixture/createDB.php');
	return "<br/>";
});


$app->get('/system/createTables', function () use ($app) {
	require(__DIR__ . '/../web/fixture/createTable.php'); 
	return "<br/>";
});
