<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MutasiSaldo extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'mut_saldo';

    protected $fillable = [
        'cha',
        'thn',
        'sa',
        'd1','d2','d3','d4','d5','d6','d7','d8','d9','d10','d11','d12',
        'k1','k2','k3','k4','k5','k6','k7','k8','k9','k10','k11','k12'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];
}
