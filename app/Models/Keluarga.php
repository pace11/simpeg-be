<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    use HasFactory;

    protected $table = 'keluarga';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'tanggal_perkawinan',
        'golongan_darah',
        'kewarganegaraan',
        'pegawai_id',
        'agama_id',
        'pendidikan_kk_id',
        'status_perkawinan_kk_id',
        'status_hubungan_kk_id',
        'jenis_pekerjaan_kk_id',
    ];
    protected $guard = [
        'created_at', 'updated_at'
    ];

    public $timestamps = true;

    public function pegawai() {
        return $this->belongsTo(Pegawai::class, 'pegawai_id', 'id');
    }

    public function agama() {
        return $this->belongsTo(Agama::class, 'agama_id', 'id');
    }

    public function pendidikan_kk() {
        return $this->belongsTo(PendidikanKk::class, 'pendidikan_kk_id', 'id');
    }

    public function status_perkawinan_kk() {
        return $this->belongsTo(StatusPerkawinanKk::class, 'status_perkawinan_kk_id', 'id');
    }

    public function status_hubungan_kk() {
        return $this->belongsTo(StatusHubunganKk::class, 'status_hubungan_kk_id', 'id');
    }

    public function jenis_pekerjaan_kk() {
        return $this->belongsTo(JenisPekerjaanKk::class, 'jenis_pekerjaan_kk_id', 'id');
    }
}
