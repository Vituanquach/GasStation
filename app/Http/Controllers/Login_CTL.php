<?php

namespace App\Http\Controllers;
use DB;
use App\Quotation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Session;
use validate;

class Login_CTL extends Controller
{
    public function index()
    {	
    	return view('login');
    }
     public function login1(Request $request)
    {	      
    		$messages = [
            'Uname.required' => 'メールを入力してください。',
            'Uname.max' => 'メールの長さは100文字を超えてはなりません',
            'Uname.email' => 'メールではありません',
            'Pass.required' => 'パスワードを入力してください。', 
            'Pass.max' => 'パスワードの長さは100文字を超えることはできません'
        	];
    	//kiểm tra điều kiện nhập
    	$vali = $request->validate([
        'Uname' => 'required|email|max:100',
        'Pass' => 'required|max:100',
    	],$messages);
            $email = $request->input('Uname');
            $password = $request->input('Pass');
            

		if (empty($vali)==Null) {
			// info user check
			
			$user = DB::table('User')->where('Email', $email)->where('Password',$password)->where('UserType','00001')->first();
			//check login
			if($user != NULL){
				$request->session()->put('idu', $user->UserId);
                return redirect('/gaslist');
			}else{
				$request->session()->flash('status', 'ログインに失敗しました。電子メールまたはパスワードを確認してください。 ');
                $request->session()->flash('user', $email);
				
				return redirect('/login');
			}
			
		}else{
			//return
			return $vali;
		}
     }




     public function logout(Request $request){
     	$request->session()->forget('idu');
     	// $request->session()->flush();
     }
} 