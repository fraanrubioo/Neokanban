<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Task;
use App\Models\ProjectUserEmail;
use App\Models\User;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'owner_email'];

    /**
     * Relación con las tareas del proyecto
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Correos electrónicos de usuarios invitados al proyecto
     */
    public function invitedUsers()
    {
        return $this->hasMany(ProjectUserEmail::class);
    }

    /**
     * Acceso directo a los usuarios invitados (relación manual por email)
     */
    public function users()
    {
        return $this->hasManyThrough(
            User::class,
            ProjectUserEmail::class,
            'project_id',       // Foreign key on ProjectUserEmail
            'email',            // Local key on User
            'id',               // Local key on Project
            'email'             // Foreign key on ProjectUserEmail
        );
    }


    /**
     * Accesor para acceder como propiedad: $project->invited_users
     */
    public function getInvitedUsersAttribute()
    {
        $emails = $this->invitedUsers()->pluck('email');
        return User::whereIn('email', $emails)->get();
    }
}
