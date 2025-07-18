<?php

class LoginController
{
    private Database $db;

    public function __construct()
    {
        $config = new Config(BASE_PATH . '/config.php');
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Access values
        $dbHost = $config->get('db_host');
        $dbUser = $config->get('db_user');
        $debugMode = $config->get('debug', true); // fallback true if missing

        $this->db = new Database(
            $dbHost,
            $config->db_name,
            $dbUser,
            $config->db_pass,
            $debugMode
        );
    }

    public function login($username, $password): bool
    {
        $user = $this->db->fetchOne("SELECT * FROM users WHERE username = ?", [$username]);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return false;
        }

        // Get permissions
        $permissions = $this->getPermissionsByRole($user['id_user_role']);

        $_SESSION['user'] = [
            'id_user' => $user['id_user'],
            'username' => $user['username'],
            'id_user_role' => $user['id_user_role'],
            'role_name' => $permissions[0]['role_name'],
            'permissions' => $permissions,
        ];

        return true;
    }

    public function logout(): void
    {
        unset($_SESSION);
        session_destroy();
        header("Location: login.php");
        exit;
    }

    public function check(): void
    {
        if (empty($_SESSION['user'])) {
            header("Location: login.php");
            exit;
        }
    }

    public function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    protected function getPermissionsByRole($roleId): array
    {
        $permissions = $this->db->fetchAll("
            SELECT rp.permission_key, rp.can_access , ur.role_name
            FROM role_permissions rp
            LEFT JOIN user_roles ur
            ON ur.id_user_role  = rp.id_user_role
            WHERE rp.id_user_role = ?
        ", [$roleId]);

        foreach ($permissions as $row) {
            $permissions[$row['permission_key']] = (bool)$row['can_access'];
        }

        return $permissions;
    }

    public static function isUserLoggedIn(): bool
    {
        return isset($_SESSION['user']) && !empty($_SESSION['user']['id_user']);
    }
}
