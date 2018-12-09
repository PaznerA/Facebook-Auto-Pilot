<?php declare(strict_types = 1);

namespace Fb2CMS\Model;

use Dibi;

class Database
{

    public static function getConnection()
    {
        try {
            return (new Dibi\Connection([
                'driver' => DB_DRIVER,
                'database' => DB_NAME,
                'profiler' => [
                    'file' => DB_LOGFILE_PATH,
                ],
            ]));
        } Catch (Dibi\Exception $DibiException) {
            return false;
        }
    }

}