<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const PAPEL_ADMIN = 'admin';
    public const PAPEL_EDITOR = 'editor';

    /** papeis aceitos e o nome mostrado no painel */
    public const PAPEIS = [
        self::PAPEL_ADMIN => 'Administrador',
        self::PAPEL_EDITOR => 'Editor',
    ];

    /** mesmos valores padrao da tabela, para o objeto ja nascer certo */
    protected $attributes = [
        'papel' => self::PAPEL_EDITOR,
        'ativo' => true,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'papel',
        'ativo',
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
    protected $casts = [
        'email_verified_at' => 'datetime',
        'ativo' => 'boolean',
        'ultimo_login' => 'datetime',
    ];

    public function ehAdmin(): bool
    {
        return $this->papel === self::PAPEL_ADMIN;
    }

    public function nomeDoPapel(): string
    {
        return self::PAPEIS[$this->papel] ?? $this->papel;
    }

    public function registrarLogin(): void
    {
        $this->forceFill(['ultimo_login' => now()])->save();
    }
}
