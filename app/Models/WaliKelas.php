<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wali_kelas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
    ];
    
    /**
     * Mengambil guru yang memiliki rombel.
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
    
    /**
     * Mengambil rombel yang memiliki guru.
     */
    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }
}
