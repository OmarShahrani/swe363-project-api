<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

$route['migrate/(:any)'] = 'migrate/index/$1';


/// USERS
$route['api/users'] = 'api/users/show';
$route['api/users/(:num)']['GET'] = 'api/users/show/$1';
$route['api/users/create']['POST'] = 'api/users/create';
$route['api/users/update']['PUT'] = 'api/users/update';
$route['api/users/destroy/(:num)']['DELETE'] = 'api/users/destroy/$1';
$route['api/users/login']['POST'] = 'api/users/login';

/// SERVICES
$route['api/services'] = 'api/services/show';
$route['api/services/(:any)']['GET'] = 'api/services/show/$1';
$route['api/services/create']['POST'] = 'api/services/create';
$route['api/services/update']['PUT'] = 'api/services/update';
$route['api/services/destroy/(:num)']['DELETE'] = 'api/services/destroy/$1';

/// Requests
$route['api/requests'] = 'api/requests/show';
$route['api/requests/(:any)']['GET'] = 'api/requests/show/$1';
$route['api/requests/create']['POST'] = 'api/requests/create';
$route['api/requests/update']['PUT'] = 'api/requests/update';
$route['api/requests/destroy/(:num)']['DELETE'] = 'api/requests/destroy/$1';
