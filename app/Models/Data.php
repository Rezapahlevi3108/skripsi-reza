<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    protected $table = "data";

    protected $fillable = [
        'nis',
        'nama',
        'kelas',
        'sbd',
        'ips',
        'ipa',
        'bing',
        'mat',
        'pa',
        'pjok',
        'pra',
        'bind',
        'pkn',
        'cluster'
    ];
}
