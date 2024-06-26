<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = 'estate';

    public function Will()
    {
        return $this->belongsTo(Wilayah::class, 'id', 'wil');
    }
}
