<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Advert;
use Carbon\Carbon;

class UpdateExpiredAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-expired-ads';
    // protected $signature = 'update:expired-ads';
   
    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';
    protected $description = 'Update the expiration date of expired ads to null and set active to false';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();
        $currentTime = $now; //adds 1hour to the time because carbon::now() is 1hour ago

        Advert::where('expiration_date', '<=', $currentTime)->where('active',true)
        ->update([
            'expiration_date' => null,
            'active' => false,
        ]);

        $this->info('Expired ads updated successfully at '.$currentTime);
    }
}
