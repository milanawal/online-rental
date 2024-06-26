<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    function update(Request $request) {
        // dd($request->all());
        $validation =$request->validate([
            'address_1'=>'',
            'address_2'=>'',
           'city'=>'nullable|max:60|regex:/^[a-zA-Z\s]*$/',
           'state'=>'nullable|max:60|regex:/^[a-zA-Z\s]*$/',
           'district'=>'nullable|max:60|regex:/^[a-zA-Z\s]*$/',
           'pincode'=>'nullable|digits_between:4,10',
           'mobile_1'=>'nullable|digits:10',
            'mobile_2'=>'nullable|digits:10',
           'country'=>'nullable|max:30|regex:/^[a-zA-Z\s]*$/',
           'citizenship'=>'required'
     // 'MobileNumber'=>'required|numeric',
      
     ]);
       print_r($validation);

       $first_name=$request->input('first_name');
     $last_name=$request->input('last_name');

     $address_1=$request->input('address_1');
     $address_2=$request->input('address_2');
     $city=$request->input('city');
     $state=$request->input('state');
     $pincode=$request->input('pincode');
     $mobile_1=$request->input('mobile_1');
     $mobile_2=$request->input('mobile_2');
     $district=$request->input('district');
     
     $country='Nepal';
     
     $user_id=Auth::user()->id;
     $user=Profile::where('user_id',$user_id)->first();
    if(empty($user)){
        $user = new Profile();
    }
    //  $user=User::findOrFail($user_id);

    $user->first_name=$first_name;
    $user->last_name=$last_name;

     $user->address_1=$address_1;
     $user->address_2=$address_2;
     $user->city=$city;
     $user->state=$state;
     $user->pincode=$pincode;
     $user->mobile_1=$mobile_1;
     $user->mobile_2=$mobile_2;
     $user->district=$district;
     
     $user->country=$country;
     $user->user_id=$user_id;
     $user->verified=0;
     $user->status=0;
     

     if($request->hasfile('citizenship'))
     {
         $destination='Uploads/profiles/'.$user->citizenship;
         if(File::exists($destination))
         {
             File::delete($destination);
         }
         $file=$request->file('citizenship');
         $extension=$file->getClientOriginalExtension();
         $filename=time() .'.'.$extension;
         $file->move('Uploads/profiles/',$filename);
         $user->citizenship=$filename;


    }

    $user->save();
    return redirect()->back()->with('successstatus', 'Your Address Data is Updated Succesfully');


    }
}
