<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers\Horario');
$routes->setDefaultController('Horario');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//$routes->get('/(:any)', 'Horario::index/$1');

/* ROUTES HORARIO */
$routes->group('/horario',['namespace'=>'App\Controllers\Horario'],function ($routes){
    $routes->get('/','Horario::index');
    $routes->get('shift/(:any)','Horario::index/$1');
    //$routes->get('shift/','Horario::index');
    $routes->get('add_profissional_horario/(:any)/(:any)/(:any)','Horario::addProfissionalHorario/$1/$2/$3');   
    $routes->post('add', 'Horario::add');     
});
$routes->group('/horario/api',['namespace'=>'App\Controllers\Horario'],function ($routes){
    // $routes->get('/','Horario::index');
    // $routes->get('add_profissional_horario/(:any)/(:any)/(:any)','Horario::addProfissionalHorario/$1/$2/$3');   
    // $routes->post('add', 'Horario::add'); 
    $routes->get('getAllocation/(:any)','ApiHorario::getAllocation/$1');    
    $routes->post('create','ApiHorario::create');    
    $routes->get('delete/(:any)','ApiHorario::deleteSchedule/$1');    
    $routes->post('del','ApiHorario::del');    
});

/* ROUTES PROFESSOR */
$routes->group('/professor',['namespace'=>'App\Controllers\Professor'],function ($routes){
    $routes->get('/','Professor::add');
    $routes->get('list','Professor::list');
    //$routes->get('add_profissional_horario/(:any)/(:any)/(:any)','Horario::addProfissionalHorario/$1/$2/$3');   
    $routes->post('create', 'Professor::create'); 
});
/* ROUTES PROFESSOR DISCIPLINA */
$routes->group('/teacDisc',['namespace'=>'App\Controllers\TeacDisc'],function ($routes){
    $routes->get('list/(:any)','TeacDisc::list/$1');
    $routes->get('show/(:any)','TeacDisc::show/$1');
    $routes->get('edit/(:any)','TeacDisc::edit/$1');
    $routes->get('delete/(:any)','TeacDisc::delete/$1');
    $routes->post('create','TeacDisc::create');
    //$routes->get('add_profissional_horario/(:any)/(:any)/(:any)','Horario::addProfissionalHorario/$1/$2/$3');   
    //$routes->post('create', 'Professor::create'); 
    $routes->post('update', 'TeacDisc::update'); 
    $routes->post('del', 'TeacDisc::del'); 
});

/* ROUTES ALOCAÇÃO */
$routes->group('/alocacao',['namespace'=>'App\Controllers\Alocacao',/*'filter'=>'accessFilter'*/],function ($routes){
    $routes->get('/','Alocacao::index');
    
    //$routes->get('add_profissional_horario/(:any)/(:any)/(:any)','Horario::addProfissionalHorario/$1/$2/$3');   
    $routes->get('add_etp02/(:any)/(:any)', 'Alocacao::add_etp02/$1/$2'); 
    $routes->post('create', 'Alocacao::create'); 
     
    //$routes->post('add', 'Alocacao::add'); 
    $routes->get('add/(:any)', 'Alocacao::add/$1'); 
    $routes->post('delete', 'Alocacao::delete'); 
});
/* ROUTES SERIES*/
$routes->group('/series',['namespace'=>'App\Controllers\Series',/*'filter'=>'accessFilter'*/],function ($routes){
   
    $routes->get('show/(:any)', 'Series::show/$1');
   
});
/* ROUTES YEAR SCHOOL*/
$routes->group('/yearSchool',['namespace'=>'App\Controllers\YearSchool',/*'filter'=>'accessFilter'*/],function ($routes){
   
    $routes->get('/', 'YearSchool::index');
    $routes->get('list', 'YearSchool::list');
    $routes->post('create', 'YearSchool::create');
    $routes->post('active', 'YearSchool::active');
   
});


/*ROUTES LOGOUT
*/
$routes->get('/logout','Home::logout');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
