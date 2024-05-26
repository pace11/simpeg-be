<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    use HasFactory;

    protected $table = 'pekerjaan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nomor_sk',
        'tanggal_sk',
        'ttd_sk',
        'keterangan',
        'pegawai_id',
    ];
    protected $guard = [
        'created_at', 'updated_at'
    ];

    public $timestamps = true;

    public function pegawai() {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
    }
}
