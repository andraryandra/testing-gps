<?php

namespace App\Models\Toko;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialStore extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'status',
        'phone',
        'email',
        'city',
        'province',
        'address',
        'postal_code',
        'latitude',
        'longitude',
        'slug',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
