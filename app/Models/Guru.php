<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'guru';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nomor_identitas', 'nama', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'nomor_telepon', 'alamat', 'foto'
    ];
    
    /**
     * User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Guru mapel.
     */
    public function guru_mapel()
    {
        return $this->hasMany(GuruMapel::class);
    }

    /**
     * Wali kelas.
     */
    public function wali_kelas()
    {
        return $this->hasMany(WaliKelas::class);
    }

    /**
     * Waka kurikulum.
     */
    public function waka_kurikulum()
    {
        return $this->hasMany(WakaKurikulum::class);
    }
}
