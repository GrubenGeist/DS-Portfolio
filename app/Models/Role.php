<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = ['name', 'slug'];

    /**
     * Get the users for the role (für BelongsTo in User).
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * The users that belong to the role (für BelongsToMany in User).
     */
    public function usersToMany(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}