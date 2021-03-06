<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use Illuminate\Http\Request;

class ReserveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $reserve = Reserve::with('user', 'room')->orderBy('status','ASC')->paginate(10);

       return [
        'paginate' => [
           'total' => $reserve->total(),
           'current' => $reserve->currentPage(), 
           'per_page' => $reserve->perPage(),
           'last_page' => $reserve->lastPage(),
           'from' => $reserve->firstItem(),
           'to' => $reserve->lastPage(),
        ],

        'reserves'=> $reserve


    ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'dateStart' => 'required',
            'dateEnd' => 'required',
            'hourStart'=> 'required',
            'hourEnd'=> 'required'
        ]);

        Reserve::create($request->all());

        $response = [
            'message' => 'Tu peticion se ha registrado con exito',
        ];

        return response($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Reserve::with('user','room')->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $reserve = Reserve::find($id);
         if(auth()->user()->id == $reserve->user_id ){
        $reserve->update($request->all());

        $response = [

            'message' => 'Tu petición ha sido modificada con exito',
           
        ];

        return response($response, 200);
    }

    else if(auth()->check() && auth()->user()->is_admin == 1){
        $reserve->update($request->all());

        $response = [

            'message' => 'La peticion ha sido modificada con exito',
           
        ];

        return response($response, 200);
    }
    return 'No tienes permiso para editar esta peticion';
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reserve = Reserve::find($id);
         
        if(auth()->user()->id == $reserve->user_id ){
            Reserve::destroy($id);
        $response = [

            'message' => 'Tu peticion ha sido borrada con exito'
        ];
        return response($response, 200);
    }
    else if(auth()->check() && auth()->user()->is_admin == 1){
        Reserve::destroy($id);
        $response = [

            'message' => 'Tu peticion ha sido borrada con exito'
        ];
        return response($response, 200);
    }
    return 'No tienes permiso para borrar esta peticion';
    }
    /**
     * Search reserves by user.
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($id)
    {

        return Reserve::where('user_id','=', ''.$id.'')->with('user','room')->get(); 
    }

    public function getStats(){

        return [
            'total' => count(Reserve::all()),
            'pending' => count(Reserve::where('status', '=', "Pending")->get()),
            'accepted' => count(Reserve::where('status', '=', "Accepted")->get()),
            'cancelled'=> count(Reserve::where('status','=', 'Cancelled')->get())


        ];
    }

    public function getStatsByUser($id){

        $user = Reserve::where('user_id', 'like', '%' . $id . '%')->get();

        return [
            'total' => count($user),
            'pending' => count($user->where('status', '=', "Pending")),
            'accepted' => count($user->where('status', '=', 'Accepted')),
            'cancelled'=> count($user->where('status','=', 'Cancelled'))
        ];

    }

    public function pendingReserve(){
       return Reserve::where('status', '=', 'Pending')->orderBy('created_at','ASC')->limit(10)->get();
    }
    
}
