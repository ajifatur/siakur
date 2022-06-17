<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'file';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file'
    ];
    
    /**
     * Guru mapel.
     */
    public function guru_mapel()
    {
        return $this->belongsTo(GuruMapel::class, 'gurumapel_id');
    }
    
    /**
     * Kelas.
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    
    /**
     * Jenis file.
     */
    public function jenis_file()
    {
        return $this->belongsTo(JenisFile::class, 'jenisfile_id');
    }
}
