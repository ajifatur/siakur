<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruMapel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_guru_mapel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
    ];
    
    /**
     * Mengambil periode.
     */
    public function period()
    {
        return $this->belongsTo(\Ajifatur\FaturHelper\Models\Period::class, 'period_id');
    }
    
    /**
     * Mengambil guru yang memiliki mapel.
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
    
    /**
     * Mengambil mapel yang memiliki guru.
     */
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }
}
