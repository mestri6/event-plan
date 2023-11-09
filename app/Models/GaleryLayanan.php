<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GaleryLayanan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'galery_layanans';
    protected $primaryKey = 'id';

    protected $guarded = [
        'id',
    ];

    //relasi one to many
    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id', 'id');
    }
}
