<?php

namespace App\Models;

use App\Models\Division; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    protected $table = 'Employees';
    protected $primaryKey = 'id_pegawai';
    public $incrementing = false;
    protected $casts = [
        'tanggal_bergabung' => 'date',
    ];
    protected $fillable = ['id_pegawai', 'nama', 'bidang', 'level', 'tanggal_bergabung', 'id_divisi', 'id_deputi', 'Roles'];

    public $timestamps = false; // Tambahkan baris ini

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'id_divisi');
    }

    public function deputy()
{
    return $this->belongsTo(Deputy::class, 'id_deputi', 'id_deputi'); // Sesuaikan nama kolom primary key di tabel 'deputies' jika berbeda
}


    public function Employeetrainings()
    {
        return $this->hasMany(EmployeeTraining::class, 'id_pegawai');
    }
    
    public function trainingRecommendations(): HasMany
    {
        return $this->hasMany(TrainingRecommendation::class, 'id_pegawai');
    }

    public function trainings(): BelongsToMany
    {
        return $this->belongsToMany(
            Training::class,
            'Employees_training',
            'id_pegawai',
            'id_pelatihan'
        )
        ->withPivot(['bobot', 'tingkat_relevansi', 'alasan_relevansi'])
        ->using(EmployeeTraining::class);
    }

    public function deputyEmployee(): BelongsTo
    {
        return $this->belongsTo(Deputy::class, 'id_deputi');
    }


}
