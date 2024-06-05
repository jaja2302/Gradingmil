<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = 'wil';

    public function Regional()
    {
        return $this->belongsTo(Regional::class, 'id', 'regional');
    }

    public function Estate()
    {
        return $this->hasMany(Estate::class, 'wil', 'id');
    }

    public function Mil()
    {
        return $this->hasMany(Mill::class, 'wil', 'id');
    }
}
