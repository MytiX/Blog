<?php

namespace App\Core\Session;

class Session
{
    private static $_instance;

    private function __construct()
    {
        $this->sessionStart();
    }

    /**
     * getSession
     * Create instance of Session, if instance existe return self
     * @return Session
     */
    public static function getSession(): Session
    {
        if (null === self::$_instance) {
            self::$_instance = new Session();
        }

        return self::$_instance;
    }

    /**
     * sessionStart
     * Initialisation of session
     * @return void
     */
    private function sessionStart(): void
    {
        session_start();
    }

    /**
     * get
     * Return a value of array $_SESSION, if not exists return null
     * @param  string $key
     * @param  mixed $return
     * @return mixed
     */
    public function get(string $key, mixed $return = null): mixed
    {
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }

        return $return;
    }

    /**
     * set
     * Set key and value in $_SESSION
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * flash
     * Get the element and unset the key
     * @param  string $key
     * @return void
     */
    public function flash(string $key): mixed
    {
        $value = $this->get($key);

        $this->remove($key);

        return $value;
    }

    /**
     * remove
     * Unset element of $_SESSION
     * @param  mixed $key
     * @return void
     */
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }
}
