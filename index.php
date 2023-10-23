<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Model;
use App\Models\Payment;
use App\Models\User;
use App\Container;

//bind to callable
Container::bind(User::class, function(){
    return new User('user_payment');
});
$user = Container::make(User::class);
var_dump($user->table);
var_dump($user->all());

//bind to another class
Container::bind(Model::class, Payment::class);
$user = Container::make(Model::class);
var_dump($user->all());

//use as a singleton
Container::singleton(User::class);
$user = Container::make(User::class);
var_dump(spl_object_id($user));

$user = Container::make(User::class);
var_dump(spl_object_id($user));
