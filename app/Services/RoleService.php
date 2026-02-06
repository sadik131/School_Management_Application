<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

class RoleService
{
    public function getAll()
    {
        return Role::with('permissions')->latest()->get();
    }

    public function create(array $data)
    {
        $role = Role::create([
            'name' => $data['name'],
        ]);

        $role->syncPermissions($data['permissions']);

        return $role;
    }

    public function edit(string $id, array $data)
    {
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $data['name'],
        ]);

        $role->syncPermissions($data['permissions'] ?? []);

        return $role;
    }

    public function delete(string $id)
    {
        $role = Role::findOrFail($id);
        return $role->delete();
    }
}

