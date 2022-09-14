<?php

namespace App\Http\Controllers;

use App\Api\ApiMessages;
use App\Http\Requests\VisitSchedulingRequest;
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

    // Construtor para visitas
    public function __construct(VisitScheduling $visit, User $user, Property $property)
    {
        $this->middleware('auth:api');
        $this->visit = $visit;
        $this->user = $user;
        $this->property = $property;
    }

    // Lista todos as visitas
    public function index()
    {
        $results = DB::select('SELECT u.user_photo, u.name, u.surname, p.street, p.house_number, p.price, v.date, v.schedule, v.status FROM users AS u INNER JOIN visit_schedulings AS v ON u.id = v.user_id INNER JOIN properties AS p ON v.property_id = p.id ORDER BY v.date DESC');

        return response()->json($results, 200);
    }

    // Cria e guarda uma novo visita
    public function store(VisitSchedulingRequest $request)
    {
        $data = $request->all();

        try {

            // Por padrão, o valor do status é "Em espera"
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

    // Função para aceitar uma visita
    public function accept($id)
    {
        try {

            $visit = $this->visit->findOrFail($id);

            // Muda o status da visita
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

    // Função para marcar uma visita como feita
    public function done($id)
    {
        try {

            $visit = $this->visit->findOrFail($id); 

            // Muda o status da visita
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

    // Função para marcar uma visita como rejeitada
    public function cancel($id)
    {
        try {

            $visit = $this->visit->findOrFail($id); 

            // Muda o status da visita
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

    // Remove uma vistia específica
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
}
