<?php

namespace App\Models\Toko;

use App\Traits\UUID;
use App\Models\Toko\OfficialStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImageOfficial extends Model
{
    use HasFactory, UUID;

    protected $primaryKey = 'id'; // Ganti 'id' dengan nama kolom UUID yang sesuai
    public $incrementing = false;
    protected $fillable = [
        'official_store_id',
        'visit_schedules_id',
        'image',
    ];

    public function officialStore()
    {
        return $this->belongsTo(OfficialStore::class, 'official_store_id');
    }
}
