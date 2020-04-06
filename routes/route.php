<?php

/**
 *  sidenav deceleration system
 * -----for get and post method :-----
 * first parameter is  api route
 * second parameter required and it's for Controller and method
 * Third parameter is option and it's for CSRF protection(Default value is false).
 *  if you want to disable accessing API  from other site. if you pass trye then this route need wp nonce token in request header as X-WP-Nonce
 *
 */


$route->get('dashboard/{id?}', 'DashboardController@dashboard');
$route->post('add-note', 'NotesController@addNote');
$route->get('get-notes', 'NotesController@getNotes');
$route->post('update-note', 'NotesController@updateNote');
$route->post('delete-note', 'NotesController@deleteNote');
$route->post('clear-completed-note', 'NotesController@clearCompletedNote');
