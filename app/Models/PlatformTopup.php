<?php

//app/Models/PlatformTopup.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformTopup extends Model
{
    protected $fillable = ['amount', 'method', 'reference', 'status'];
}