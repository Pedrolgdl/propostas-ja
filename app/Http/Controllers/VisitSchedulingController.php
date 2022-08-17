<?php

namespace App\Http\Controllers;

use App\Api\ApiMessages;
use App\Mail\VisitAccepted;
use App\Mail\VisitCanceled;
use App\Mail\VisitSolicitation;
use App\Models\Property;
use App\Models\User;
use App\Models\VisitScheduling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class VisitSchedulingController extends Controller
{
    private $visit;
    private $user;
    private $property;

    public function __construct(VisitScheduling $visit, User $user, Property $property)
    {
        $this->middleware('auth:api');
        $this->visit = $visit;
        $this->user = $user;
        $this->property = $property;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorna as visitas
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

            $user = $this->user->findOrfail($data['user_id']);
            $property = $this->property->findOrfail($data['property_id']);

            Mail::to(env('ADMIN_MAIL'))->send(new VisitSolicitation($visit, $user, $property, true));
            //Mail::to($user->email)->send(new VisitSolicitation($visit, $user, $property, false));

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

            $user = $this->user->findOrfail($visit['user_id']);
            $property = $this->property->findOrfail($visit['property_id']);

            Mail::to(env('ADMIN_MAIL'))->send(new VisitAccepted($visit, $user, $property, true));
            //Mail::to($user->email)->send(new VisitAccepted($visit, $user, $property, false));

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

            $user = $this->user->findOrfail($visit['user_id']);
            $property = $this->property->findOrfail($visit['property_id']);

            Mail::to(env('ADMIN_MAIL'))->send(new VisitCanceled($visit, $user, $property, true));
            //Mail::to($user->email)->send(new VisitCanceled($visit, $user, $property, false));

            return response()->json([
                'data' => [
                    'msg' => 'Visita rejeitada com sucesso.'
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
