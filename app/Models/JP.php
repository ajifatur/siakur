<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JP extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jp';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hari', 'jam_mulai', 'jam_selesai'
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
