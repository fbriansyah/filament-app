<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'order_id',
        'service_id',
        'assign_to',
        'price',
        'status',
        'scheduled_at',
        'note',
    ];

    protected $casts = [
        'id' => 'string',
        'price' => 'decimal:2',
        'scheduled_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function assignTo()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }
}
