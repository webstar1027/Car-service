<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\CarService as CarServiceNotification;
use App\User;
use App\Model\Notification;
use App\Model\NotificationType;
use App\Model\Userofcar;
use App\Model\Car;
class carNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carNotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command check all user car notification periodically and then send notification';

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
      $users = User::all();
      $current_date = date("Y-m-d", strtotime('now'));
      foreach($users as $user){
        $user_id = $user->id;
        $user_cars = Userofcar::where('user_id', $user_id)->get();       
        foreach($user_cars as $user_car) {
          if($user_car['notification_status'] == 1) {
            $carinfo = Car::where('id', $user_car['car_id'])->first();
            $notifications = Notification::where('userofcar_id', $user_car['userofcar_id'])->get();
            foreach($notifications as $notification){
              $servicedate = date('Y-m-d', strtotime($user_car['created_at']));
              $notificationdate = date('Y-m-d', strtotime('+'.$notification['status'].' months', strtotime($servicedate)));
              if ($current_date >= $notificationdate ) {
                $notification_type = NotificationType::where('notification_type_id', $notification['notification_type_id'])->first();
                switch ($notification_type['notification_type_name']) {
                  case 'oil change':
                    $user->notify(new CarServiceNotification($user_car, 'Engine Oil Change', $carinfo));
                    break;
                  case 'transmission':
                    $user->notify(new CarServiceNotification($user_car, 'Transmission Oil Change', $carinfo));
                    break;    
                  case 'general inspection':
                    $user->notify(new CarServiceNotification($user_car, 'General Inspection', $carinfo));
                    break; 
                  case 'brake check':
                    $user->notify(new CarServiceNotification($user_car, 'Brake Check', $carinfo));
                    break; 
                  case 'tire check':
                    $user->notify(new CarServiceNotification($user_car, 'Tire Check', $carinfo));
                    break;              
                
                }
              }

            }
           
          }

        }
      }
    }
}
