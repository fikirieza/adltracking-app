<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_number',
        'delivery_date',
        'destination',
        'receiver',
        'driver_id',
        'created_by',
        'updated_by',
    ];

    // Relasi ke Driver (User)
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    // Relasi ke Admin (User)
    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Relasi ke ShipmentItem
    public function items()
    {
        return $this->hasMany(ShipmentItem::class);
    }
}
