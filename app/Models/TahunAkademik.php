<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tahun_akademik';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tahun', 'semester', 'status'
    ];

    // /**
    //  * Get the users for the role.
    //  */
    // public function users()
    // {
    //     return $this->hasMany(User::class);
    // }

    // /**
    //  * The permissions that belong to the role.
    //  */
    // public function permissions()
    // {
    //     return $this->belongsToMany(Permission::class, 'role__permission', 'role_id', 'permission_id');
    // }
}
