<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaRombel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'anggota_rombel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'no_urut'
    ];
    
    /**
     * Mengambil rombel.
     */
    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }
    
    /**
     * Mengambil siswa.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
