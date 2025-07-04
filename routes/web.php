$router->get('/usuarios', 'UserController@index');
$router->get('/usuarios/buscar', 'UserController@buscar');
$router->get('users', 'UserController@index');
$router->get('users/create', 'UserController@create');
$router->post('users/store', 'UserController@store');
$router->get('users/edit', 'UserController@edit');
$router->post('users/update', 'UserController@update');
$router->get('users/delete', 'UserController@delete');
$router->get('users/view', 'UserController@view');
$router->get('users/reactivate', 'UserController@reactivate');
$router->get('users/reset-password', 'UserController@resetPassword');
$router->post('users/change-role', 'UserController@changeRole');
$router->get('users/block', 'UserController@block');
$router->get('users/unblock', 'UserController@unblock');
$router->get('permissions', 'PermissionController@index');
$router->get('permissions/create', 'PermissionController@create');
$router->post('permissions/store', 'PermissionController@store');
$router->get('permissions/edit', 'PermissionController@edit');
$router->post('permissions/update', 'PermissionController@update');
$router->get('permissions/delete', 'PermissionController@delete');
// Ejes (Axes)
$router->get('axes', 'AxisController@index');
$router->get('axes/view', 'AxisController@view');
$router->get('axes/create', 'AxisController@create');
$router->post('axes/store', 'AxisController@store');
$router->get('axes/edit', 'AxisController@edit');
$router->post('axes/update', 'AxisController@update');
$router->get('axes/delete', 'AxisController@delete');

// Programas (Program)
$router->get('programs', 'ProgramController@index');
$router->get('programs/view', 'ProgramController@view');
$router->get('programs/create', 'ProgramController@create');
$router->post('programs/store', 'ProgramController@store');
$router->get('programs/edit', 'ProgramController@edit');
$router->post('programs/update', 'ProgramController@update');
$router->get('programs/delete', 'ProgramController@delete');

// Líneas de acción (action_lines)
$router->get('action_lines', 'ActionLineController@index');
$router->get('action_lines/view', 'ActionLineController@view');
$router->get('action_lines/create', 'ActionLineController@create');
$router->post('action_lines/store', 'ActionLineController@store');
$router->get('action_lines/edit', 'ActionLineController@edit');
$router->post('action_lines/update', 'ActionLineController@update');
$router->get('action_lines/delete', 'ActionLineController@delete');

// Componentes (components)
$router->get('components', 'ComponentController@index');
$router->get('components/view', 'ComponentController@view');
$router->get('components/create', 'ComponentController@create');
$router->post('components/store', 'ComponentController@store');
$router->get('components/edit', 'ComponentController@edit');
$router->post('components/update', 'ComponentController@update');
$router->get('components/delete', 'ComponentController@delete');

// Organizaciones (organizations)
$router->get('organizations', 'OrganizationController@index');
$router->get('organizations/view', 'OrganizationController@view');
$router->get('organizations/create', 'OrganizationController@create');
$router->post('organizations/store', 'OrganizationController@store');
$router->get('organizations/edit', 'OrganizationController@edit');
$router->post('organizations/update', 'OrganizationController@update');
$router->get('organizations/delete', 'OrganizationController@delete');

// Metas (goals)
$router->get('goals', 'GoalController@index');
$router->get('goals/view', 'GoalController@view');
$router->get('goals/create', 'GoalController@create');
$router->post('goals/store', 'GoalController@store');
$router->get('goals/edit', 'GoalController@edit');
$router->post('goals/update', 'GoalController@update');
$router->get('goals/delete', 'GoalController@delete');

// Financiadores (financiers)
$router->get('financiers', 'FinancierController@index');
$router->get('financiers/view', 'FinancierController@view');
$router->get('financiers/create', 'FinancierController@create');
$router->post('financiers/store', 'FinancierController@store');
$router->get('financiers/edit', 'FinancierController@edit');
$router->post('financiers/update', 'FinancierController@update');
$router->get('financiers/delete', 'FinancierController@delete');

// Proyectos (projects)
$router->get('projects', 'ProjectController@index');
$router->get('projects/view', 'ProjectController@view');
$router->get('projects/create', 'ProjectController@create');
$router->post('projects/store', 'ProjectController@store');
$router->get('projects/edit', 'ProjectController@edit');
$router->post('projects/update', 'ProjectController@update');
$router->get('projects/delete', 'ProjectController@delete');

// Objetivos específicos (specific_objectives)
$router->get('specific_objectives', 'SpecificObjectiveController@index');
$router->get('specific_objectives/view', 'SpecificObjectiveController@view');
$router->get('specific_objectives/create', 'SpecificObjectiveController@create');
$router->post('specific_objectives/store', 'SpecificObjectiveController@store');
$router->get('specific_objectives/edit', 'SpecificObjectiveController@edit');
$router->post('specific_objectives/update', 'SpecificObjectiveController@update');
$router->get('specific_objectives/delete', 'SpecificObjectiveController@delete');