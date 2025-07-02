$router->get('/api/roles', 'RoleController@apiRoles');

// Rutas para usuarios
$router->get('/api/users', 'UserController@index');
$router->post('/api/users', 'UserController@store');
$router->get('/api/users/{id}', 'UserController@show');
$router->put('/api/users/{id}', 'UserController@update');
$router->delete('/api/users/{id}', 'UserController@destroy');
$router->get('/api/users/buscar', 'UserController@buscar');