<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nilai';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jenis', 'ulangan', 'nilai'
    ];
    
    /**
     * Mengambil jam pelajaran yang memiliki jadwal.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
    
    /**
     * Guru mapel.
     */
    public function guru_mapel()
    {
        return $this->belongsTo(GuruMapel::class, 'gurumapel_id');
    }
}
