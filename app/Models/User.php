<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Role checking methods
     */
    public function isIntern()
    {
        return $this->role === 'intern';
    }

    public function isSupervisor()
    {
        return $this->role === 'supervisor';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Relationships
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'intern_id', 'user_id');
    }

    public function weeklyReports()
    {
        return $this->hasMany(WeeklyReport::class, 'intern_id', 'user_id');
    }

    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'supervisor_id', 'user_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id', 'user_id');
    }

    public function interns()
    {
        return $this->hasMany(User::class, 'supervisor_id', 'user_id');
    }

    public function logs()
    {
        return $this->hasMany(LogEntry::class);
    }
}