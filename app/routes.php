<?php



$app->get('/','HomeController:index')->setName('home');


$app->get('/auth/signup','AuthController:getSignUp')->setName('auth.signup');
$app->post('/auth/signup','AuthController:postSignUp');

//login routes
$app->get('/auth/signin','AuthController:getSignIn')->setName('auth.signin');
$app->post('/auth/signin','AuthController:postSignIn');
//logaut
$app->get('/auth/signout','AuthController:getSignOut')->setName('auth.signout');