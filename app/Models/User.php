<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'phone',
        'avatar',
        'status',
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
     * Role constants
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_TEACHER = 'teacher';
    const ROLE_STAFF = 'staff';
    const ROLE_STUDENT = 'student';

    /**
     * Get all available roles
     */
    public static function getRoles()
    {
        return [
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_TEACHER => 'Guru',
            self::ROLE_STAFF => 'Staff',
            self::ROLE_STUDENT => 'Siswa',
        ];
    }

    /**
     * Check if user has admin role
     */
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user has teacher role
     */
    public function isTeacher()
    {
        return $this->role === self::ROLE_TEACHER;
    }

    /**
     * Check if user has staff role
     */
    public function isStaff()
    {
        return $this->role === self::ROLE_STAFF;
    }

    /**
     * Check if user has student role
     */
    public function isStudent()
    {
        return $this->role === self::ROLE_STUDENT;
    }

    /**
     * Check if user has specific role
     */
    public function hasRole($role)
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }
        return $this->role === $role;
    }

    /**
     * Check if user can access feature
     */
    public function canAccess($feature)
    {
        $permissions = [
            'admin' => ['*'], // Admin can access everything
            'teacher' => [
                'dashboard',
                'presensi',
                'nilai',
                'jadwal',
                'siswa.view',
                'laporan.akademik',
            ],
            'staff' => [
                'dashboard',
                'data_pokok',
                'keuangan',
                'laporan.keuangan',
            ],
            'student' => [
                'dashboard',
                'nilai.view',
                'jadwal.view',
            ],
        ];

        // Admin can access everything
        if ($this->isAdmin()) {
            return true;
        }

        // Check if role has permission
        if (isset($permissions[$this->role])) {
            return in_array($feature, $permissions[$this->role]) || 
                   in_array('*', $permissions[$this->role]);
        }

        return false;
    }

    /**
     * Get role badge color
     */
    public function getRoleBadgeColor()
    {
        return match($this->role) {
            self::ROLE_ADMIN => 'red',
            self::ROLE_TEACHER => 'blue',
            self::ROLE_STAFF => 'green',
            self::ROLE_STUDENT => 'purple',
            default => 'gray',
        };
    }

    /**
     * Get role display name
     */
    public function getRoleDisplayName()
    {
        return self::getRoles()[$this->role] ?? 'Unknown';
    }

    /**
     * Get user initials for avatar
     */
    public function getInitials()
    {
        $words = explode(' ', $this->name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }

    /**
     * Scope for active users
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for specific role
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }
}