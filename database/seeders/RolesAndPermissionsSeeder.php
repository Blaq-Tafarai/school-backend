<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        // Create permissions for admin
        $adminPermissions = [
            'view all students',
            'view all teachers',
            'add student',
            'edit student',
            'delete student',
            'add teacher',
            'edit teacher',
            'delete teacher',
            'view announcements',
            'add announcement',
            'edit announcement',
            'delete announcement',
            'view events',
            'add event',
            'edit event',
            'delete event',
            'view blogs',
            'add blog',
            'edit blog',
            'delete blog',
            'view classrooms',
            'add classroom',
            'edit classroom',
            'delete classroom',
            'view gallery',
            'add gallery',
            'edit gallery',
            'delete gallery',
            'view contacts',
            'view admissions',
        ];

        // Create permissions for teacher
        $teacherPermissions = [
            'view classroom students',
            'view assignments',
            'add assignment',
            'edit assignment',
            'delete assignment',
            'view grades',
            'add grade',
            'edit grade',
            'delete grade',
            'view attendance',
            'mark attendance',
            'view resources',
            'add resource',
            'edit resource',
            'delete resource',
        ];

        // Create permissions for student
        $studentPermissions = [
            'view own profile',
            'view own attendance',
            'view own grades',
            'view own resources',
            'view own assignments',
        ];

        // Create all permissions
        $allPermissions = array_merge($adminPermissions, $teacherPermissions, $studentPermissions);
        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole->syncPermissions($adminPermissions);
        $teacherRole->syncPermissions($teacherPermissions);
        $studentRole->syncPermissions($studentPermissions);
    }
}
