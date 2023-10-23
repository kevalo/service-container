<?php

namespace App\Models;

class User extends Model
{
    public function all(): array
    {
        return [
            ['id' => 1, 'name' => 'Kevin'],
            ['id' => 2, 'name' => 'Jose'],
        ];
    }
}
