<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Doctrine\DBAL\Connection as DoctrineConnection;
use Exception;
use LogicException;
use PDO;
use PDOStatement;
use Illuminate\Support\Facades\DB;

class CreateDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

     Protected $signature = 'make:database {dbname} {connection?}';


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
         $dbname = $this->argument('dbname');
         $connection = $this->hasArgument('connection') && $this->argument('connection') ? $this->argument('connection'): DB::connection()->getPDO()->getAttribute(PDO::ATTR_DRIVER_NAME);

         $hasDb = DB::connection($connection)->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "."'".$dbname."'");

         if(empty($hasDb)) {
             DB::connection($connection)->select('CREATE DATABASE '. $dbname);
             $this->info("Database '$dbname' created for '$connection' connection");
         }
         else {
             $this->info("Database $dbname already exists for $connection connection");
         }
     }
     catch (\Exception $e){

        try{
            $dbname = $this->argument('dbname');
            $connection = $this->hasArgument('connection') && $this->argument('connection') ? $this->argument('connection'): DB::connection()->getPDO()->getAttribute(PDO::ATTR_DRIVER_NAME);   
       
            DB::connection($connection)->select('CREATE DATABASE '. $dbname);
            $this->info("Database '$dbname' created for '$connection' connection");
         
        }
        catch (\Exception $e){
              
            $this->error($e->getMessage());
        }             
     }
   }
}
