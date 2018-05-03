<?php
namespace App\Services;

class NewNotifiable
{
	use \Illuminate\Notifications\Notifiable;
    public $email;
    public function __construct($email)
    {
        $this->email = $email;
    }
}