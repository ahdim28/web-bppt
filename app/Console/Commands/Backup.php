<?php

namespace App\Console\Commands;

use App\Services\BackupService;
use Illuminate\Console\Command;

class Backup extends Command
{
    private $service;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Database Backup';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        BackupService $service
    )
    {
        $this->service = $service;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filePath = 'backup/db-backup-'.now()->format('Y-m-d').'.sql';
        $command = "mysqldump --user=".env('DB_USERNAME')." --password=". env('DB_PASSWORD').
            " --host=".env('DB_HOST')." ".env('DB_DATABASE')."  | gzip > ".storage_path().
            "/app/".$filePath;
  
        $returnVar = NULL;
        $output  = NULL;

        $this->service->backup($filePath, 1);
  
        exec($command, $output, $returnVar);
    }
}
