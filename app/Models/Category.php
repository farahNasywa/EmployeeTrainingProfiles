<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'Categories';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;

    public function trainings(): HasMany
    {
        return $this->hasMany(Training::class, 'id_kategori');
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class, 'id_kategori');
    }
}