<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'adresse',
        'cin',
        'code_copie',
        'id_copie',
        'photo_path',
        'face_info',
        'password',
        'profession',
        'statut',
        'district',
        'nom_pere',
        'prenom_pere',
        'nom_mere',
        'prenom_mere',
        'nom_conjoint',
        'prenom_conjoint',
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
        'date_naissance' => 'date',
    ];


    /**
     * Get all of the Files for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    /**
     * Get all of the DemandeServices for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function DemandeServices(): HasMany
    {
        return $this->hasMany(DemandeService::class);
    }

}
