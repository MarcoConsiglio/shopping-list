<?php
use Illuminate\Database\Migrations\Migration;
trait SQLiteMigration
{
    /**
     * Controlla che la connessione al database sia SQLite.
     *
     * @return bool
     */
    public function isSQLite()
    {
        $connection = config("database.connections");
        switch($connection)
        {
            case "sqlite":
                return true;
            break;
            case "dusk":
                return true;
            break;
            default:
                return false;
            break;
        }
    }
}
