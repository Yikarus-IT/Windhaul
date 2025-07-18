<?php

class UserController
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

    public static function hasPermission($permissionKey): bool
    {
        return !empty($_SESSION['user']['permissions'][$permissionKey]);
    }

    public static function getRoleName(): string
    {
        return $_SESSION['user']['role_name'];
    }
}
