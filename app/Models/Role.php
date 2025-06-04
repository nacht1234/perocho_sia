<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Optional: Define the table name explicitly if it's not standard
    protected $table = 'roles';

    // Mass assignable attributes
    protected $fillable = ['name'];

    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
