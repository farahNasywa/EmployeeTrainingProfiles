<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecommendationType extends Model
{
    protected $primaryKey = 'id_jenis_rekomendasi';
    protected $table = 'Recommendations_type';
    public $timestamps = false; // tabel tidak punya created_at / updated_at

    public function trainingRecommendations(): HasMany
    {
        return $this->hasMany(TrainingRecommendation::class, 'id_jenis_rekomendasi');
    }
}