<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rombel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama'
    ];
    
    /**
     * Mengambil kelas yang memiliki rombel.
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    
    /**
     * Mengambil jurusan yang memiliki rombel.
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
