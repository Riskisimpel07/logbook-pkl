<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'name',
        'role',
        'nim_nis',
        'email',
        'password',
        'foto',
        'sekolah_kampus',
        'jurusan',
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
        'password' => 'hashed',
    ];

    // Relationships
    public function logbooks()
    {
        return $this->hasMany(Logbook::class);
    }

    public function validatedLogbooks()
    {
        return $this->hasMany(Logbook::class, 'validated_by');
    }

    public function pembimbing()
    {
        return $this->belongsToMany(User::class, 'pembimbing_mahasiswa', 'mahasiswa_id', 'pembimbing_id');
    }

    public function mahasiswaBimbingan()
    {
        return $this->belongsToMany(User::class, 'pembimbing_mahasiswa', 'pembimbing_id', 'mahasiswa_id');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }

    public function isPembimbing()
    {
        return $this->role === 'pembimbing';
    }
}
