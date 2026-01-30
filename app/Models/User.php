<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo User
 * 
 * Representa a los usuarios del sistema (Clientes y Administradores).
 * Gestiona la autenticación, roles y relaciones con reservas y comentarios.
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Atributos asignables masivamente.
     * 
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol' // 'admin', 'advanced', 'user'
    ];

    /**
     * Atributos ocultos en la serialización (JSON).
     * 
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting de atributos nativos.
     * 
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación: Un usuario puede tener muchas reservas.
     */
    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class);
    }

    /**
     * Relación: Un usuario puede tener muchos comentarios.
     */
    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class);
    }

    /**
     * Verifica si el usuario tiene un rol específico.
     *
     * @param string $role Rol a comprobar ('admin', 'user', etc.)
     * @return bool True si coincide, False en caso contrario.
     */
    public function hasRole($role): bool
    {
        return $this->rol === $role;
    }

    /**
     * Verifica si el usuario es administrador.
     *
     * @return bool True si es admin.
     */
    public function isAdmin(): bool
    {
        return $this->rol === 'admin';
    }
}
