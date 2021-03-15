<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Doctrine\DBAL\Connection as DoctrineConnection;
use Exception;
use LogicException;
use PDO;
use PDOStatement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

     Protected $signature = 'make:database';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
     try{
         $dbname = env('DB_DATABASE', 'laravel');
         $dbhost = env('DB_HOST', '127.0.0.1');
         $dbuser = env('DB_USERNAME', 'forge');
         $dbpassword =  env('DB_PASSWORD', '');


        
          // Connect to MySQL
        $link = mysqli_connect($dbhost, $dbuser, $dbpassword);
        if (!$link) {
            die('Could not connect: ' . mysql_error());
        }

        // Make my_db the current database
        $db_selected = mysqli_select_db($link, $dbname);

        if ($db_selected) {
            echo "Database $dbname already exists\n";
        }

        if (!$db_selected) {
        // If we couldn't, then it either doesn't exist, or we can't see it.
        $sql = "CREATE DATABASE $dbname";

        if (mysqli_query( $link, $sql)) {
            echo "Database $dbname created successfully\n";
        } else {
            echo 'Error creating database: ' . mysql_error() . "\n";
        }
        }

        mysqli_close($link);


     }
     catch (\Exception $e){


            $this->error($e->getMessage());
          
     }
   }
}
