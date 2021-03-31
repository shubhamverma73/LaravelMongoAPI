<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Userdatamodel;

class Userdata extends Controller
{
    function index() {
    	$product = Userdatamodel::all();
        return $product;
    }

    function signup(Request $request) {

    	$get = json_decode($request->getContent());

    	if(empty($get->email)) {
    		return array('status'=>'-1', 'data'=>'', 'message'=>'Email can not be blank');
    	}

    	$data = Userdatamodel::where('email', $get->email)->first();

    	if(empty($data->email)) {
    		$token = bin2hex(openssl_random_pseudo_bytes(16));

			$user = new Userdatamodel;
			$user->name = $get->name;
			$user->email = $get->email;
			$user->username = $get->phone;
			$user->password = $get->password;
			$user->city = $get->city;
			$user->state = $get->state;
			$user->address = $get->address;
			$user->pincode = $get->pincode;
			$user->phone = $get->phone;
			$user->date = date('Y-m-d');
			$user->time = date('H:i:s');
			$user->status = true;
			$user->token = $token;
			$user->save();
			$status = $user->id;

			if($status > 0) {

				$response[] = array(
					'status' => true,
					'name' => $get->name,
					'email' => $get->email,
					'phone' => $get->phone,
					'city' => $get->city,
					'token' => $token
				);

				return array('status'=>'2', 'data'=>$response, 'message'=>'');
			} else {
				return array('status'=>'1', 'data'=>'', 'message'=>'Registration failed, try again.');
			}
		} else {
			return array('status'=>'0', 'data'=>'', 'message'=>'User already exists.');
		}
    }

    function signin(Request $request) {
    	$get = json_decode($request->getContent());

    	//DB::connection()->enableQueryLog();
    	$data = Userdatamodel::where('email', $get->email)->where('password', $get->password)->first();
    	//dd(DB::getQueryLog());
    	//debug($data);

    	if(!empty($data->email)) {

	    	if($data->status == false) {
	    		return array('status'=>'0', 'data'=>'', 'message'=>'Your acount is inactive, contact with your manager');
	    	}

    		$response[] = array(
				'status' => true,
				'name' => $data->name,
				'email' => $data->email,
				'phone' => $data->phone,
				'city' => $data->city,
				'token' => $data->token
			);
			return array('status'=>'2', 'data'=>$response, 'message'=>'');
    	} else {
    		return array('status'=>'1', 'data'=>'', 'message'=>'Invalid User');
    	}
    }

    function profile(Request $request) {
    	$get = json_decode($request->getContent());
		$email = $get->email;
		$token = $get->token;

		authenticate($email, $token);
    	$data 	= Userdatamodel::where('email', $email)->get();
    	if(!empty($data[0]->email)) {
			return array('status'=>'2', 'data'=>$data, 'message'=>'');
    	} else {
    		return array('status'=>'1', 'data'=>'', 'message'=>'No Data');
    	}
    	
    }

    function update_profile(Request $request) {

    	$get = json_decode($request->getContent());
		$id = $get->id;
		$data = array( 
							"name" => $get->name,
							//"username" => $get->username,
							//"email" => $get->email,
							"phone" => $get->phone,
							"city" => $get->city,
							"state" => $get->state,
							"address" => $get->address,
							"pincode" => $get->pincode
						);
		$updateData = Userdatamodel::where('_id', $id)->update($data);

		if(!empty($updateData)) {
			return array('status'=>'2', 'data'=>'', 'message'=>'Profile updated successfully.');
		} else {
			return array('status'=>'1', 'data'=>'', 'message'=>'Profile not updated, try again.');
		}
    }

    function delete(Request $request) {
    	$get = json_decode($request->getContent());
		$id = $get->id;
    	$data 	= Userdatamodel::where('_id', $id)->delete();
    	if($data == true) {
			exit(json_encode(array('status'=>'1', 'data'=>'', 'message'=>'data deleted successfully.')));
		} else {
			exit(json_encode(array('status'=>'0', 'data'=>'', 'message'=>'data not deleted, try again.')));
		}
    }
}
