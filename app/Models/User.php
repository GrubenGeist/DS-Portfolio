<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable; // Wenn Sie Notifikationen verwenden
use Illuminate\Database\Eloquent\Factories\HasFactory; // Wenn Sie Factories verwenden

class User extends Authenticatable
{
    use HasFactory, Notifiable; // Verwenden Sie die Traits

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // Wenn Sie role_id direkt zuweisen wollen, fügen Sie es hinzu
        // 'role_id', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the role that belongs to the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * The roles that belong to the user (für Many-to-Many).
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Überprüft, ob der Benutzer eine bestimmte Rolle hat (für BelongsTo).
     */
    public function hasRole(string $roleSlug): bool
    {
        return $this->role()->where('slug', $roleSlug)->exists();
    }

    /**
     * Überprüft, ob der Benutzer eine der angegebenen Rollen hat (für BelongsTo).
     */
    public function hasAnyRole(array $roleSlugs): bool
    {
        return $this->role()->whereIn('slug', $roleSlugs)->exists();
    }

    /**
     * Überprüft, ob der Benutzer eine bestimmte Rolle hat (für BelongsToMany).
     */
    public function hasRoleByName(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    /**
     * Überprüft, ob der Benutzer eine der angegebenen Rollen hat (für BelongsToMany).
     */
    public function hasAnyRoleByName(array $roleNames): bool
    {
        return $this->roles()->whereIn('name', $roleNames)->exists();
    }
}