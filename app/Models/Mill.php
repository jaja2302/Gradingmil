<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mill extends Model
{
    use HasFactory;

    protected $table = 'list_mill';


    public function Wilayah()
    {
        return $this->belongsTo(Mill::class, 'id', 'wil');
    }
}
