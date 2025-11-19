<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal',
        'kegiatan',
        'foto_kegiatan',
        'status',
        'validated_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isValidated()
    {
        return $this->status === 'validated';
    }
}
