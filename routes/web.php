$router->get('/usuarios', 'UserController@index');
$router->get('/usuarios/buscar', 'UserController@buscar');
$router->get('users', 'UserController@index');
$router->get('users/create', 'UserController@create');
$router->post('users/store', 'UserController@store');
$router->get('users/edit', 'UserController@edit');
$router->post('users/update', 'UserController@update');
$router->get('users/delete', 'UserController@delete');