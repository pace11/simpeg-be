<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    use HasFactory;

    protected $table = 'pendidikan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nomor_ijazah',
        'nama_instansi',
        'jurusan',
        'tanggal_lulus',
        'pegawai_id',
        'pendidikan_terakhir_id',
    ];
    protected $guard = [
        'created_at', 'updated_at'
    ];

    public $timestamps = true;

    public function pegawai() {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
    }

    public function pendidikan_terakhir() {
        return $this->belongsTo(PendidikanTerakhir::class, 'pendidikan_terakhir_id', 'id');
    }
}
