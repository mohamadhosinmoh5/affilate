<?php
namespace App\class\db;
use Illuminate\Support\Facades\DB;

class Tb{
    protected static $dbName;

    public static function get($db) {

        static::$dbName = $db;
        return DB::table(static::$dbName);

    }
}