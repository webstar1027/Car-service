<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Master;
use App\Model\Masterserviceofshop;
class expireService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expireService';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'expire service 15 days from when it created at';

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
     * @return mixed
     */
    public function handle()
    {
        //

        /*
         *  this will expire service from masterserviceofshop table
         */

        $masterservices = Masterserviceofshop::all();
        $current_date = date("Y-m-d", strtotime('now'));
        foreach ($masterservices as $item) {
            $servicedate = date('Y-m-d', strtotime($item['created_at']));
            $expiredate = date('Y-m-d', strtotime('+15 days', strtotime($servicedate)));
            if($current_date > $expiredate) {
                Masterserviceofshop::where('masterserviceofshop_id', $item['masterserviceofshop_id'])->update([
                    'status' => 1
                ]);
            }
        }

    }
}
