<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function register(Request $request){

        $fields = $request->validate([

            'name'=> 'required|string',
            'email'=> 'required|string|unique:users,email',
            'password'=>'required|string|confirmed',
            
            

        ]);

        $user = User::create([
            'name'=> $fields['name'],
            'email'=> $fields['email'],
            'password'=>bcrypt($fields['password']),
            'rol_id'=> 2,
           
            

        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response= [
            'user' => $user,
            'token'=> $token


        ];

        return response($response, 201);

    }


    public function logout(Request $request){

        auth()->user()->tokens()->delete();

        return [

            'message' => 'Logged out'

        ];
    }


    public function login(Request $request){

        $fields = $request->validate([
            'email' => 'required|string',
            'password'=> 'required|string'
        ]);

        // Check mail
        $user = User::where('email',$fields['email'])->first();

        //Check password
        if(!$user || !Hash::check($fields['password'], $user->password)){

            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

        public function index(){

            return User::with('rol')->get();


        }

        public function show($id){

            return User::with('rol')->find($id);
        }
        

        public function update(Request $request, $id){
            $user = User::find($id);
            $fields = $request->validate([

                'name'=> 'string',
                'email'=> 'string',
                'password'=>'string',
                'phone_number'=>'string',
                'rol_id'=>'numeric',
                
    
            ]);

            $user->update([
               
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => bcrypt($fields['password']),
                'phone_number' => $fields['phone_number'],
                'rol_id' => $fields['rol_id']

            ]);

            return $user;
         
        }


}
