<?php

namespace App\Http\Controllers;

use App\Api\ApiMessages;
use App\Models\VisitScheduling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitSchedulingController extends Controller
{
    private $visit;

    public function __construct(VisitScheduling $visit)
    {
        $this->middleware('auth:api');
        $this->visit = $visit;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorna os documentos
        $visits = $this->visit->all();

        return response()->json($visits, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        try {

            $data['status'] = 'Em espera';
            $visit = $this->visit->create($data);

            return response()->json([
                'data' => [
                    'msg' => 'Visita agendada com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    // Método para aceitar uma visita
    public function accept($id)
    {
        try {

            $visit = $this->visit->findOrFail($id);
            $visit->update([$visit['status'] = 'Marcada']);

            return response()->json([
                'data' => [
                    'msg' => 'Visista marcada com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    // Método para marcar uma visita como feita
    public function done($id)
    {
        try {

            $visit = $this->visit->findOrFail($id); 
            $visit->update([$visit['status'] = 'Feita']);

            return response()->json([
                'data' => [
                    'msg' => 'Visista feita com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    // Método para marcar uma visita como rejeitada
    public function cancel($id)
    {
        try {

            $visit = $this->visit->findOrFail($id); 
            $visit->update([$visit['status'] = 'Rejeitada']);

            return response()->json([
                'data' => [
                    'msg' => 'Visista rejeitada com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $visit = $this->visit->findOrFail($id); 
            $visit->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Visita removida com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }



// --------------------------------------------------------------------

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
    public function update(Request $request, $id)
    {
        //
    }
}
