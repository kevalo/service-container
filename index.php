<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Model;
use App\Models\Payment;
use App\Models\User;
use App\Container;

//bind to a class
Container::bind(Model::class, Payment::class);
$model = Container::make(Model::class);
dump($model);

//bind to callable
Container::bind(User::class, function(){
    $user = Container::resolve(User::class);
    $user->table = 'users';
    return $user;
});
$user = Container::make(User::class);
dump($user);

//use as a singleton
Container::singleton(Payment::class, User::class);
$payment1 = Container::make(Payment::class);
$payment1->table = "payments";

$payment2 = Container::make(Payment::class);
dump($payment1, $payment2);

function dump(...$vars): void
{
    var_dump(...$vars);
    echo "---------------------------------------------\n";
}
