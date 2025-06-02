<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'owner_email'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function invitedUsers()
    {
        return $this->hasMany(ProjectUserEmail::class);
    }

}
