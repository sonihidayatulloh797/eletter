<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    public $timestamps = false;

    protected $fillable = [
        'name', 'description'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id');
    }

    public function syncPermissions(array $permissionIds)
    {
        $this->permissions()->sync($permissionIds);
    }

    public function can($permissionName, $arguments = [])
    {
        // Jika Super Admin / admin, otomatis boleh akses semua
        if ($this->hasRole('admin')) {
            return true;
        }

        // Cek apakah role memiliki permission
        return $this->role
            && $this->role->permissions->contains('name', $permissionName);
    }
}
