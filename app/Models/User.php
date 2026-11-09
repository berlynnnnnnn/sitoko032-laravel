<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 't032_users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'id_role',
        'username',
        'password',
        'nama_lengkap',
        'email',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'id_user', 'id_user');
    }

    public function apiTokens(): HasMany
    {
        return $this->hasMany(ApiToken::class, 'id_user', 'id_user');
    }

    public function hasRole(string|array $roles): bool
    {
        $roleName = $this->role->nama_role ?? '';
        if (is_array($roles)) {
            return in_array($roleName, $roles, true);
        }
        return $roleName === $roles;
    }
}
