<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = 'string';

    protected $fillable = [
        "name",
        "code",
        "price",
        "duration",
        "unit",
        "place",
        "description",
        "status"
    ];

    protected function casts(): array
    {
        return [
            "id" => "string",
            "price" => "decimal:2",
            "duration" => "integer",
            "status" => "string",
        ];
    }
}
