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
    public function index()
    {
        return Reserve::with('user', 'room')->get();
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
            'message' => 'Tu petición se ha registrado con éxito'
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
        return Reserve::find($id);
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
        $reserve->update($request->all());

        $response = [

            'message' => 'Tu petición ha sido modificada con éxito'
        ];

        return response($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Reserve::destroy($id);

        $response = [

            'message' => 'Tu petición ha sido borrada con éxito'
        ];
        return response($response, 200);
    }
    /**
     * Search reserves by user.
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($id)
    {

        return Reserve::where('user_id', 'like', '%' . $id . '%')->get();
    }
}
