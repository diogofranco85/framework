<?php
use Core\Route as route;
$request = new Core\Routes\Request();

/* ROTA RAIZ */
route::get('/', 'HomeController@index');


//route::get(['set' => '/blog', 'as' => 'blog.index'], 'BlogController@index');
//route::get('/blog/article/{id}/{name}', 'BlogController@read');

//route::get('/manager','ManagerController@index');
//route::get('/manager/login','ManagerController@login');
//route::get('/manager/logout','ManagerController@logout');
//route::post('/manager/authenticate','ManagerController@userauth');

// route::put(['set' => '/teste', 'as' => 'teste.index'], function(){
//   header('content-type: application/json');
//   echo json_encode(['teste' => 'ok','message' => 'method delete']);
// });
//route::get('/api/articles', 'APIController@articles');
//route::get('/api/articles/{id}','APIController@articles');

route::resolve($request);
