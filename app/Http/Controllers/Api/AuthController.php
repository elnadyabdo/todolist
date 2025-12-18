<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class AuthController extends Controller
{
    public function register(Request $request){
    $validate=$request->validate([
        'name'=>['required','string','max:255'],
        'email'=>['required','email','max:255',],
        'password'=>['required','confirmed','min:8'],
        'password_cofirm'=>['required','confirmed','min:8'],
        
    ]
    );
   $user=user::create([
    'name'=>$validate['name'],
    'email'=>$validate['email'],
    'passowrd'=>Hash::make($validate['passowrd'])
   ]); 
   $token=$user->createToken('apiaToken')->plaintTextToken;
   return response->json([
    'status'=>true,
    'message'=>'تم إنشاء الحساب بنجاح',
    'data'   =>[
        'id'=>$user->id,
        'name'=>$user->name,
        'email'=>$user->email,
        'token'=>$user->token,
    ] 
   ]);
}  
    public function login(Request $request){
    $validate=$request->validate([
        'name'=>['required','string','max:255'],
        'email'=>['required','email','max:255','uniqe:users,email'],
        'password'=>['required','confirmed','min:8'],
        
    ]
    );

   $user=User::create([
    'name'=>$validate['name'],
    'email'=>$validate['email'],
    'passowrd'=>Hash::make($validate['passowrd'])
   ]); 
   if(!Auth::attempt){
    
        return response->json([
            'status'=>false,
            'message'=>[
                'invalid credintails'
            ]
        ]);
    
   }
   $user=Auth::user();
   $token=$user->createToken('apiToken')->plaintTextToken;
   return response->json([
    'status'=>true,
    'message'=>'تم الدخول إلى الحساب بنجاح.مرحبا بعودتك',
    'data'   =>[
        'id'=>$user->id,
        'name'=>$user->name,
        'email'=>$user->email,
        'token'=>$user->token,
    ] 
   ]);
}
}
