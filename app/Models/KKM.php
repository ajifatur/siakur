<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KKM extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kkm';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jenis', 'kkm', 'deskripsi_a', 'deskripsi_b', 'deskripsi_c', 'deskripsi_d'
    ];
    
    /**
     * Mengambil kelas yang memiliki KKM.
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    
    /**
     * Mengambil mapel yang memiliki KKM.
     */
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }
}
