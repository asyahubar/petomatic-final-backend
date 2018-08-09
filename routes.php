<?php

// authentication
$router->get('api/logout', 'Authenticate@logout');
$router->post('api/validate', 'Authenticate@validate');

// browse
$router->get('api/owners', 'OwnersController@getowners');
$router->get('api/owner/{id}/pets', 'OwnersController@getpetsbyowner');

$router->get('api/visittypes', 'VisitsController@getvisittypes');
$router->post('api/visit/add', 'VisitsController@addvisit');
$router->get('api/visits', 'VisitsController@getvisitstoday');
$router->post('api/visit/{id}/edit', 'VisitsController@editvisit');
