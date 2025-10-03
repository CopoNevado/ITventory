<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UsuarioLogin extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios_login';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false; // tu tabla no tiene created_at/updated_at

    protected $fillable = [
        'usuario',
        'password_hash',
        'rol',
        'intentos_fallidos',
        'bloqueado',
        'telefono_soporte',
        'fecha_creacion',
        'fecha_ultimo_intento',
        'fecha_bloqueo',
    ];

    // Como Laravel por defecto usa "password"
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
