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
        return $this->belongsToMany(User::class, 'project_user_emails', 'project_id', 'email', 'id', 'email');
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
