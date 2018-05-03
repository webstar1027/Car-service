<?php

namespace App\Http\Controllers;

use App\Mail\InsuranceUpload;
use App\Mail\LicenseUpload;
use Illuminate\Support\Facades\Auth;
use Mail;
use Illuminate\Http\Request;
use App\Model\File;
use Illuminate\Support\Facades\Storage;
use App\Notifications\FileUpload as FileUpload;
use Notification;
use App\User;
use Webpatser\Uuid\Uuid as Uuid;
use Validator;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    
    public function getShopOwner() {
        return view('pages.shoppage.mainshopowner');
    }

    public function getSubscription(){
        return view('pages.shoppage.subscription');
    }
    public function shopRegister() {
        return view('pages.shoppage.register');
    }   

    public function postInsurance(Request $request){          
 
      $this->validate($request, array(
            'license' => 'required|mimes:pdf, jpeg',
            'insurance' => 'required|mimes:pdf, jpeg',
      )); 
      
      $filedata = File::where('user_id', Auth::user()->id)->get();
      if($request->hasFile('insurance') && $request->hasFile('license')) {  
        // insurance data
        $insurance = $request->file('insurance');
        $name1 = explode('.', $insurance);
        $filename1 =  $name1[0]. '.' . $insurance->getClientOriginalExtension();
        $document_id1 = '5555'.Uuid::generate();
        $filede1 = $insurance->move('.', $insurance->getClientOriginalName());   

        // license data
        $license = $request->file('license');
        $name2 = explode('.', $license);
        $filename2 = $name2[0]. '.' . $license->getClientOriginalExtension();
        $document_id2 = '6666'. Uuid::generate();
        $filede2 = $license->move('.', $license->getClientOriginalName()); 

        if(count($filedata) > 0) {
          
          File::where('user_id', Auth::user()->id)->where('file_type', 0)->update([
            'document_id' =>$document_id1,
            'file_name' => $insurance->getClientOriginalName(),
            'status' => 0
          ]);
          File::where('user_id', Auth::user()->id)->where('file_type', 1)->update([
            'document_id' =>$document_id2,
            'file_name' => $license->getClientOriginalName(),
            'status' => 0
          ]);

        }
        else{

          $file = new File;
          $file->user_id = Auth::user()->id;
          $file->document_id = $document_id1;
          $file->file_type = 0;
          $file->file_name = $insurance->getClientOriginalName();
          $file->save();
        

          $file = new File;
          $file->user_id = Auth::user()->id;
          $file->document_id = $document_id2;
          $file->file_type = 1;
          $file->file_name = $license->getClientOriginalName();
          $file->save();
          
         
        }
        $insurance_file = array(
          'insurance_id' => $document_id1,
          'insurance_name' => $insurance->getClientOriginalName()
        );
        $license_file = array(
          'license_id' => $document_id2,
          'license_name' => $license->getClientOriginalName()
        );
        session()->put('insurance', $insurance_file);
        Mail::to('documents@maintfy.com')->send(new InsuranceUpload( $filede1)); 
        session()->put('license', $license_file);
        Mail::to('documents@maintfy.com')->send(new LicenseUpload( $filede2));
             
      }     
      return redirect('/shop/profile');
    }  
    public function getSign() {
      return view('pages.shoppage.shoplogin');
    }


}
