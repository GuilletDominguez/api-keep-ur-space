<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function updatePersonalInfo(Request $request, $id){
        $user = User::find($id);
        $fields = $request->validate([

            'name'=> 'string',
            'email'=> 'string',
            'phone_number'=>'string',

        ]);

        $user->update([
           
            'name' => $fields['name'],
            'email' => $fields['email'],
            'phone_number' => $fields['phone_number'],
          

        ]);

        return $user;
     
    }
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function updateSecretInfo(Request $request, $id){
        $user = User::find($id);
        $fields = $request->validate([

            'current_password'=> 'string|required',
            'rol_id'=> 'numeric',
            'password'=>'string',

        ]);

   //Check password
   if(!$user || !Hash::check($fields['current_password'], $user->password)){

    return response([
        'message' => 'Bad creds'
    ], 401);
}
        $user->update([
           
            'password' => bcrypt($fields['password']),
            'rol_id' => $fields['rol_id'],
            
          

        ]);

        return [
            'status'=> 200,
            'user'=>$user
        ];
     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
