<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeaponReport extends Model
{
    protected $guarded=['id'];
    
    /** @use HasFactory<\Database\Factories\WeaponReportFactory> */
    use HasFactory;
}
