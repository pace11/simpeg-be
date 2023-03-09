<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'nip_lama',
        'nip_baru',
        'tmt_golongan',
        'tmt_jabatan',
        'pendidikan_terakhir',
        'jurusan',
        'tahun_lulus',
        'pd_pdp_npd',
        'keterangan',
        'golongan_id',
        'jabatan_id',
        'agama_id',
    ];
    protected $guard = [
        'created_at', 'updated_at'
    ];
    protected $dates = [
        'deleted_at'
    ];

    public $timestamps = true;

    public function agama() {
        return $this->belongsTo(Agama::class, 'agama_id', 'id');
    }
}
