<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EmployeeTraining extends Pivot
{
    protected $table = 'Employees_training';
    public $timestamps = false; // tabel pivot tidak punya created_at / updated_at

    protected $fillable = [
        'id_pegawai',
        'id_pelatihan',
        'bobot',
        'tingkat_relevansi',
        'alasan_relevansi',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_pegawai', 'id_pegawai');
    }

    public function training()
    {
        return $this->belongsTo(Training::class, 'id_pelatihan', 'id_pelatihan');
    }
}