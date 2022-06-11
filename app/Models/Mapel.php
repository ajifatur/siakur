<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mapel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'kode', 'num_order'
    ];

    /**
     * Guru mapel.
     */
    public function guru_mapel()
    {
        return $this->hasMany(GuruMapel::class);
    }

    // /**
    //  * The permissions that belong to the role.
    //  */
    // public function permissions()
    // {
    //     return $this->belongsToMany(Permission::class, 'role__permission', 'role_id', 'permission_id');
    // }
}
