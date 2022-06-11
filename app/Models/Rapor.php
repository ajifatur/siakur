<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapor extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rapor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sikap_spiritual_predikat', 'sikap_spiritual_deskripsi', 'sikap_sosial_predikat', 'sikap_sosial_deskripsi', 'status'
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
