<?php

namespace App\Core\Session;

class Session
{
    private static $_instance;

    private function __construct()
    {
        $this->sessionStart();
    }

    public static function getSession(): Session
    {
        if (null === self::$_instance) {
            self::$_instance = new Session();
        }

        return self::$_instance;
    }

    private function sessionStart(): void
    {
        session_start();
    }

    public function get(string $key, mixed $return = null): mixed
    {
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }

        return $return;
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function flash($key)
    {
        $value = $this->get($key);

        $this->remove($key);

        return $value;
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
