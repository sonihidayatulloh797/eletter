<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Buat permission
        $permissions = [
            ['name' => 'manage_users', 'description' => 'Mengelola data user'],
            ['name' => 'manage_letters', 'description' => 'Mengelola surat masuk & keluar'],
            ['name' => 'view_reports', 'description' => 'Melihat laporan'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm['name']], $perm);
        }

        // Buat role
        $roles = [
            'admin' => ['manage_users', 'manage_letters', 'view_reports'],
            'staff' => ['manage_letters'],
            'dosen' => ['view_reports'],
            'mahasiswa' => [],
        ];

        foreach ($roles as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName], [
                'description' => ucfirst($roleName),
            ]);

            $role->permissions()->sync(
                Permission::whereIn('name', $perms)->pluck('id')->toArray()
            );
        }
    }
}
