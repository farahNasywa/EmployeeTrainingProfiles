<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Training extends Model
{
    protected $primaryKey = 'id_pelatihan';
    protected $table = 'Trainings';
    public $timestamps = false;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_kategori');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class, 'id_subkategori');
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(
            Employee::class,
            'Employees_training',
            'id_pelatihan',
            'id_pegawai'
        )
        ->withPivot(['bobot', 'tingkat_relevansi', 'alasan_relevansi'])
        ->using(EmployeeTraining::class);
    }
}