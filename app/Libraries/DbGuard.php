<?php

namespace App\Libraries;

use CodeIgniter\Database\Exceptions\DatabaseException;
use Throwable;

class DbGuard
{
    private static ?bool $available = null;

    public static function available(): bool
    {
        if (self::$available !== null) {
            return self::$available;
        }

        try {
            $db = db_connect();
            $db->initialize();
            $db->query('SELECT 1');
            self::$available = true;
        } catch (Throwable) {
            self::$available = false;
        }

        return self::$available;
    }

    /**
     * @template T
     * @param callable(): T $callback
     * @param T             $default
     * @return T
     */
    public static function run(callable $callback, mixed $default = null): mixed
    {
        if (! self::available()) {
            return $default;
        }

        try {
            return $callback();
        } catch (DatabaseException) {
            return $default;
        } catch (Throwable) {
            return $default;
        }
    }
}
