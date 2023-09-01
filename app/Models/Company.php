<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Company extends Model
{
    protected $fillable = ['images', 'name', 'addedBy'];
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}

