<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::create(['name' => 'admin']);
        $role_editor = Role::create(['name' => 'editor']);
        
        $permission_create_role = Permission::create(['name' => 'create_roles']);
        $permission_read_role = Permission::create(['name' => 'read_roles']);
        $permission_update_role = Permission::create(['name' => 'update_roles']);
        $permission_delete_role = Permission::create(['name' => 'delete_roles']);

        $permission_create_faction = Permission::create(['name' => 'create_factions']);
        $permission_read_faction = Permission::create(['name' => 'read_factions']);
        $permission_update_faction = Permission::create(['name' => 'update_factions']);
        $permission_delete_faction = Permission::create(['name' => 'delete_factions']);

        $permission_create_classrole = Permission::create(['name' => 'create_classroles']);
        $permission_read_classrole = Permission::create(['name' => 'read_classroles']);
        $permission_update_classrole = Permission::create(['name' => 'update_classroles']);
        $permission_delete_classrole = Permission::create(['name' => 'delete_classroles']);

        $permission_create_race = Permission::create(['name' => 'create_races']);
        $permission_read_race = Permission::create(['name' => 'read_races']);
        $permission_update_race = Permission::create(['name' => 'update_races']);
        $permission_delete_race = Permission::create(['name' => 'delete_races']);

        $permission_create_weapon = Permission::create(['name' => 'create_weapons']);
        $permission_read_weapon = Permission::create(['name' => 'read_weapons']);
        $permission_update_weapon = Permission::create(['name' => 'update_weapons']);
        $permission_delete_weapon = Permission::create(['name' => 'delete_weapons']);

        $permissions_admin = [
            $permission_create_role,
            $permission_read_role,
            $permission_update_role,
            $permission_delete_role,
            $permission_create_faction,
            $permission_read_faction,
            $permission_update_faction,
            $permission_delete_faction,
            $permission_create_classrole,
            $permission_read_classrole,
            $permission_update_classrole,
            $permission_delete_classrole,
            $permission_create_race,
            $permission_read_race,
            $permission_update_race,
            $permission_delete_race,
            $permission_create_weapon,
            $permission_read_weapon,
            $permission_update_weapon,
            $permission_delete_weapon,
        ];

        $permissions_editor = [
            $permission_create_faction,
            $permission_read_faction,
            $permission_update_faction,
            $permission_delete_faction,
            $permission_create_classrole,
            $permission_read_classrole,
            $permission_update_classrole,
            $permission_delete_classrole,
            $permission_create_race,
            $permission_read_race,
            $permission_update_race,
            $permission_delete_race,
            $permission_create_weapon,
            $permission_read_weapon,
            $permission_update_weapon,
            $permission_delete_weapon,
        ];

        $role_admin->syncPermissions($permissions_admin);
        $role_editor->syncPermissions($permissions_editor);

    }
}
