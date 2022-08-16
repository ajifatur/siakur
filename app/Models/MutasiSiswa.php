<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiSiswa extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mutasi_siswa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tujuan', 'tanggal'
    ];
    
    /**
     * Mengambil siswa yang memiliki mutasi.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Mutasi Siswa.
     */
    public function mutasi_siswa()
    {
        return $this->hasOne(MutasiSiswa::class);
    }
}
