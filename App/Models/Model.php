<?php

namespace App\Models;

abstract class Model
{
    public function __construct(public string $table = '')
    {
    }
}
