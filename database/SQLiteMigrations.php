<?php
namespace Database;
use Illuminate\Support\Facades\DB;

/**
 * Add support to SQLite database for a test case.
 */
trait SQLiteMigrations {
    public function isSQLiteDatabase() {
        if(DB::connection()->getDriverName() == "sqlite")
            return true;
        else
            return false;
    }
}
