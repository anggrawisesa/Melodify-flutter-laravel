<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lagu extends Model
{
    use HasFactory;
    protected $table = 'lagu';

    protected $fillable = [
        'judul', 'penyanyi', 'album', 'cover', 'file',
    ];
}