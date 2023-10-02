<?php

namespace App\Models\Toko;

use App\Traits\UUID;
use App\Models\Categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfficialStore extends Model
{
    use HasFactory, UUID;
    protected $primaryKey = 'id'; // Ganti 'id' dengan nama kolom UUID yang sesuai
    public $incrementing = false;
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

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->id = Uuid::uuid4()->toString();
    //     });
    // }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }
}
