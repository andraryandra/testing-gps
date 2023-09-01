<?php

namespace App\Models\Sales;

use App\Models\User;
use App\Models\Toko\OfficialStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visit extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'official_store_id',
        'ip_address',
        'check_in',
        'check_out',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function official_store()
    {
        return $this->belongsTo(OfficialStore::class, 'official_store_id', 'id');
    }
}
