<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('page/(:any)', 'Home::pages/$1');
// $routes->setDefaultController('Auth');
// $routes->setAutoRoute(true);

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->match(['get', 'post'], 'register', 'Auth::register');

$routes->get('dashboard', 'Admin::dashboard');
$routes->get('dashboard/getUsers', 'Admin::getUsers');

$routes->get('profile', 'User::index');
$routes->post('profile/update', 'User::update');
    
$routes->get('articles', 'Article::index');
$routes->post('articles/create', 'Article::store');
$routes->match(['get', 'post'], 'articles/update/(:num)', 'Article::update/$1');
$routes->post('articles/add_media/(:num)', 'Article::storeMedia/$1');
$routes->post('articles/update_media/(:num)', 'Article::updateMedia/$1');
$routes->add('articles/update_status/(:num)', 'Article::updateStatus');
$routes->get('articles/delete/(:num)', 'Article::delete/$1');
$routes->get('articles/delete_media/(:num)', 'Article::deleteMedia/$1');
$routes->get('articles/(:any)', 'Article::show/$1');

$routes->get('media', 'ArticleMedia::index');
$routes->get('media/add-modals', 'ArticleMedia::storeModals');
$routes->post('media/create', 'ArticleMedia::store');
$routes->post('media/update/{:num}', 'Article::update/$1');
$routes->match(['get', 'post'], 'media/update/(:num)', 'ArticleMedia::update/$1');
$routes->get('media/delete/(:num)', 'ArticleMedia::delete/$1');

$routes->get('pages', 'Page::index');
$routes->post('pages/create', 'Page::store');
$routes->match(['get', 'post'], 'pages/update/(:num)', 'Page::update/$1');
$routes->get('pages/delete/(:num)', 'Page::delete/$1');
$routes->post('pages/create/content/(:num)', 'Content::store/$1');
$routes->post('pages/update/content/(:num)', 'Content::update/$1');
$routes->get('pages/delete/content/(:num)', 'Content::delete/$1');
$routes->get('pages/(:any)', 'Page::show/$1');

$routes->get('categories', 'Category::index');
$routes->post('categories/create', 'Category::store');
$routes->post('categories/create/article/(:num)', 'ArticleCategory::store/$1');
$routes->add('categories/update/(:num)', 'Category::update/$1', ['get', 'post']);
$routes->get('categories/delete/(:num)', 'Category::delete/$1');
$routes->get('categories/delete/article/(:num)', 'ArticleCategory::delete/$1');

$routes->get('tags', 'Tag::index');
$routes->post('tags/create', 'Tag::store');
$routes->post('tags/create/article/(:num)', 'ArticleTag::store/$1');
$routes->add('tags/update/(:num)', 'Tag::update/$1', ['get', 'post']);
$routes->get('tags/delete/(:num)', 'Tag::delete/$1');
$routes->get('tags/delete/article/(:num)', 'ArticleTag::delete/$1');

$routes->get('users', 'Admin::index');
$routes->post('users/create', 'Admin::store');
$routes->match(['get', 'post'], 'users/update/(:any)', 'Admin::update/$1');
$routes->get('users/delete/(:num)', 'Admin::delete/$1');

$routes->get('logout', 'Auth::logout');
