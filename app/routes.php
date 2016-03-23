<?php

/*
$app->get('/index/{name}', function ($name) use ($app) {
	
    return 'Hello '.$app->escape($name);
});
*/

$app->get('/index', function () use ($app) {
	
    $links = $app['dao.link']->findAll();
    
	ob_start();
	require(__DIR__ . '/../views/viewIndex.php');
	$view = ob_get_clean();
    return $view;
});

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
