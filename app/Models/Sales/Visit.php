<?php

namespace App\Models\Sales;

use App\Models\User;
use App\Traits\UUID;
use App\Models\Toko\OfficialStore;
use App\Models\VisitSchedules;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visit extends Model
{
    use HasFactory, UUID;
    protected $fillable = [
        'user_id',
        'official_store_id',
        'visit_schedules_id',
        'ip_address',
        'check_in',
        'check_out',
        'latitude',
        'longitude',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function official_store()
    {
        return $this->belongsTo(OfficialStore::class, 'official_store_id', 'id');
    }

    public function visit_schedules()
    {
        return $this->belongsTo(VisitSchedules::class, 'visit_schedules_id', 'id');
    }
}
