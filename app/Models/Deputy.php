<?php

namespace App\Models;

use App\Models\Division;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deputy extends Model
{
    protected $table = 'Deputies';
    protected $primaryKey = 'id_deputi';
    public $timestamps = false;

    public function divisions(): HasMany
    {
        return $this->hasMany(Division::class, 'id_deputi');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'id_deputi');
    }

    // Kepala deputi (pegawai yang memimpin deputi ini)
    public function kepalaPegawai(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'id_pegawai');
    }
}