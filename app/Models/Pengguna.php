<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;
    use \Staudenmeir\LaravelCte\Eloquent\QueriesExpressions;
    protected $table = 'user';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'jabatan',
        'nip',
        'position_id',
        'atasan_id',
        'foto'
    ];
}
