<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WakaKurikulum extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'waka_kurikulum';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
    ];
    
    /**
     * Mengambil guru yang menjadi waka kurikulum.
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}
