<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories extends Model
{
    use HasFactory, UUID;
    // protected $primaryKey = 'id'; // Ganti 'id' dengan nama kolom UUID yang sesuai
    public $incrementing = false;
    protected $fillable = [
        'name',
        'detail',
    ];
}
