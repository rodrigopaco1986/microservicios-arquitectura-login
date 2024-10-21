<?php

namespace Rpj\Login\Database;

final class DatabaseFactory
{
    public static function factory(string $databaseClassname): IDatabase
    {
        $concreteDatabase = match ($databaseClassname) {
            SqliteDatabase::class => new SqliteDatabase(STORAGE_PATH.DB_NAME.'.sqlite'),
            //MysqlDatabase::class =>
            //    new MysqlDatabase(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD),
            default => new SqliteDatabase(STORAGE_PATH.DB_NAME.'.sqlite'),
        };

        return $concreteDatabase;
    }
}
