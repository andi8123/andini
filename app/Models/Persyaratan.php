<?php

namespace App\Models;

use App\Models\Assesor\CatinPersyaratan;
use App\Models\Master\Periode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persyaratan extends Model
{
    use HasFactory;

    protected $table = 'ref_persyaratan';
    protected $guarded = ['id'];

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id', 'id');
    }

    public function catin_persyaratan()
    {
        return $this->hasOne(CatinPersyaratan::class, 'persyaratan_id', 'id');
    }
}
