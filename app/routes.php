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

$app->post('/link/add/{url}',function($url) use ($app) {
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

$app->post('/categ/add/{name}',function($name) use ($app) {
	
	return $app['dao.categorie']->addCategorie($name);
})->bind('addCateg');


$app->post('/categ/swap/{doubleId}',function($doubleId) use ($app) {
	$ids = explode("_",$doubleId);
	return $app['dao.categorie']->changeCategorie($ids[0],$ids[1]);
})->bind('changeCateg');


$app->post('/categ/remove/{idCateg}',function($idCateg) use ($app) {
	return $app['dao.categorie']->removeCategorie($idCateg);
})->bind('removeCateg');

$app->post('/link/archive/{id}',function($id) use ($app) {
	return $app['dao.link']->archiveLink($id);
})->bind('archiveLink');

$app->post('/link/remove/{id}',function($id) use ($app) {
	return $app['dao.link']->removeLink($id);
})->bind('removeLink');


$app->get('/fixture/createDB', function () use ($app) {
	require(__DIR__ .'/../web/createDB.php');
	return "<br/>";
});

/*
$app->get('/info', function () use ($app) {
    return phpinfo();//'Hello '.$app->escape($name);
});



$app->get('/system/createTable', function () use ($app) {
	require(__DIR__ . '/../web/DB/createTable.php'); 

	//return phpinfo();//'Hello '.$app->escape($name);
	return "<br/>";
});
*/
