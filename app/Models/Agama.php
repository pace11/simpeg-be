<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'agama';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'title',
    ];
    protected $guard = [
        'created_at', 'updated_at'
    ];
    protected $dates = [
        'deleted_at'
    ];

    public $timestamps = true;

    public function pegawai() {
        return $this->hasMany(Pegawai::class);
    }
}
