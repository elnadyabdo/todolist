<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // العلاقة العكسية: كل Task يتبع User واحد
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}



