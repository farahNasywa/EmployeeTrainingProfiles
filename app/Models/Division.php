<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Division extends Model
{
    protected $table = 'Divisions';
    protected $primaryKey = 'id_divisi';
    public $timestamps = false;

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'id_divisi', 'id_divisi');
    }

    public function deputy(): BelongsTo
    {
        return $this->belongsTo(Deputy::class, 'id_deputi');
    }

    // Kepala divisi (pegawai yang memimpin divisi ini)
    public function kepalaPegawai(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'id_pegawai');
    }
}