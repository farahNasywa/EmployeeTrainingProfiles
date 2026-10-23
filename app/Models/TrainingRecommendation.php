<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingRecommendation extends Model
{
    protected $primaryKey = 'id_rekomendasi';
    protected $table = 'Training_recommendations';
    public $timestamps = false; // tabel tidak punya created_at / updated_at

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'id_pegawai');
    }

    public function recommendationType(): BelongsTo
    {
        return $this->belongsTo(RecommendationType::class, 'id_jenis_rekomendasi');
    }
}