<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'code',
        'discount',
        'scheduled_at',
        'status',
        'address',
        'note',
    ];

    protected $casts = [
        'id' => 'uuid',
        'discount' => 'decimal:2',
        'scheduled_at' => 'datetime',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
