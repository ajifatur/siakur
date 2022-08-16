<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'siswa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nomor_identitas', 'nama', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'nomor_telepon', 'alamat', 'foto'
    ];
    
    /**
     * User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Mutasi Siswa.
     */
    public function mutasi_siswa()
    {
        return $this->hasOne(MutasiSiswa::class);
    }
}
