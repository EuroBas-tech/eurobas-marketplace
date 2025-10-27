<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;


class TakeTranslationsBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:backUp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the resources/lang folder every 3 hours';

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
        $timestamp = Carbon::now()->format('Y_m_d_His');
        $source = resource_path('lang');
        $destinationFolder = base_path('lang-backup');
        $destination = $destinationFolder . "/lang_" . $timestamp;

        if (!File::exists($destinationFolder)) {
            File::makeDirectory($destinationFolder, 0755, true);
        }

        File::copyDirectory($source, $destination);

        $this->info("Lang folder backed up to: {$destination}");
        
        \Log::debug('lang backup successfully');
        
    }


}
