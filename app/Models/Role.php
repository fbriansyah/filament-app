<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    protected $casts = [
        'id' => 'string',
        'users.pivot.metadata' => 'array',
    ];

    protected $keyType = 'string';

    public function Users()
    {
        return $this
            ->belongsToMany(User::class, 'user_roles')
            ->withPivot(['id', 'metadata']);
    }
}
