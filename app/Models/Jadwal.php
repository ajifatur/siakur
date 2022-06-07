<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jadwal';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hari'
    ];
    
    /**
     * Mengambil jam pelajaran yang memiliki jadwal.
     */
    public function jp()
    {
        return $this->belongsTo(JP::class, 'jp_id');
    }
    
    /**
     * Mengambil rombel yang memiliki jadwal.
     */
    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }
    
    /**
     * Mengambil guru mapel yang memiliki jadwal.
     */
    public function guru_mapel()
    {
        return $this->belongsTo(GuruMapel::class, 'gurumapel_id');
    }
}
