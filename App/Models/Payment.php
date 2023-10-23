<?php

namespace App\Models;

class Payment extends Model
{
    public function all(): array
    {
        return [['id' => 1, 'user_id' => 1, 'amount' => 50000]];
    }
}
