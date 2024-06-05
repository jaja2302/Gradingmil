<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regional extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = 'reg';

    public function wilayah()
    {
        return $this->hasMany(Wilayah::class, 'regional', 'id');
    }

    // public function Category()
    // {
    //     return $this->belongsTo(Category::class, 'new_category', 'id');
    // }

    // public function CalibrationHistory()
    // {
    //     return $this->hasMany(CalibrationHistory::class, 'id', 'equipment_id');
    // }
}
