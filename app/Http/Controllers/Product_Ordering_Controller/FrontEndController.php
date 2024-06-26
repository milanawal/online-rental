<?php
namespace App\Http\Controllers\Product_Ordering_Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Models\Products;
use App\Models\Profile;

class FrontEndController extends Controller
{
    public function index(Request $request, $purl)
    {
        
        $Product=Products::where('url','=',$purl)->first();
        $user = Profile::where('user_id',$Product->owner_id)->first();
        if(!empty($user) && $user->verified==1){
            $verified=true;
        }else{
            $verified = false;
        }
         return view('Product-Order-Screens.Product_Page')->with('Product',$Product)->with('verified',$verified);
    }
}