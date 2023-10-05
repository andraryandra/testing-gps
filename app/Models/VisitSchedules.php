<?php

namespace App\Models;

use App\Models\User;
use App\Traits\UUID;
use App\Models\Sales\Visit;
use App\Models\Toko\ImageOfficial;
use App\Models\Toko\OfficialStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitSchedules extends Model
{
    use HasFactory, UUID;

    // protected $primaryKey = 'id'; // Ganti 'id' dengan nama kolom UUID yang sesuai
    public $incrementing = false;
    protected $fillable = [
        'user_id',
        'official_store_id',
        'custom_visit_day',
        'custom_visit_note',
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->id = Uuid::uuid4()->toString();
    //     });
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function official_store()
    {
        return $this->belongsTo(OfficialStore::class, 'official_store_id');
    }

    public function visit_sales()
    {
        return $this->hasMany(Visit::class, 'visit_schedules_id');
    }

    public function image_officials()
    {
        return $this->hasMany(ImageOfficial::class, 'visit_schedules_id');
    }
}
