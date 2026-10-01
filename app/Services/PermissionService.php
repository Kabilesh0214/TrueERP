<?php
class PermissionService
{
    private array $rolePermissions;

    public function __construct()
    {
        $config = require BASE_PATH . '/config/permissions.php';
        $this->rolePermissions = $config['roles'] ?? [];
    }

    public function can(string $role, string $module): bool
    {
        $permissions = $this->rolePermissions[$role] ?? [];
        return in_array($module, $permissions, true);
    }
}
