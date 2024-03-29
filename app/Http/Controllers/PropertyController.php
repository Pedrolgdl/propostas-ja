<?php

namespace App\Http\Controllers;

use App\Api\ApiMessages;
use App\Models\Property;
use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Mail\NotifyMail;
use App\Mail\PropertyApproved;
use App\Mail\PropertyCreated;
use App\Mail\RemoveSolicitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\DocBlock\Tags\PropertyRead;

class PropertyController extends Controller
{
    private $property;
    private $user;

    // Construtor para imóvel
    public function __construct(Property $property, User $user)
    {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'filters']]);
        $this->middleware('role')->only(['approveProperty', 'switchUnableProperty', 'propertiesAdminList']);
        $this->property = $property;
        $this->user = $user;
    }

     

    // Lista todos os imóveis
    public function index()
    {
        $property = $this->property->all();
 
        return response()->json($property, 200);
    }

    // Lista todos os imóveis para a lista de Admin
    public function propertiesAdminList()
    {
        $property = DB::select('SELECT u.user_photo, u.name, u.surname, u.email, u.telephone, p.price, p.type, p.street, p.house_number, p.city, p.state, p.size, p.number_rooms, p.furnished FROM users AS u INNER JOIN properties AS p ON u.id = p.user_id ORDER BY p.created_at DESC');
 
        return response()->json($property, 200);
    }


    // Cria e guarda um novo imóvel
    public function store(PropertyRequest $request)
    {
        $data = $request->all();
        $images = $request->file('images');

        try {

            $property = $this->property->create($data); 

            // Caso existam imagens, guarda no banco
            if($images) 
            {
                $imagesUploaded = [];

                foreach ($images as $image) {
                    $path = $image->store('photos', 'public');
                    $imagesUploaded[] = ['photo' => $path, 'is_thumb' => false];
                }

                $property->photos()->createMany($imagesUploaded);
            }

            $user = $this->user->findOrfail($property['user_id']);

            Mail::to(env('ADMIN_MAIL'))->send(new PropertyCreated($user, $property, true));
            Mail::to(env('ADMIN_MAIL'))->send(new PropertyCreated($user, $property, false));

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel cadastrado com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    // Retorna um imóvel específico
    public function show($id)
    {
        try {

            // Procura o imóvel com suas fotos
            $property = $this->property->with('photos')->findOrFail($id); 

            return response()->json([
                    'data' => $property
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    // Atualiza um imóvel específico
    public function update(PropertyRequest $request, $id)
    {
        $data = $request->all();
        $images = $request->file('images');

        try {

            $property = $this->property->findOrFail($id); 
            $property->update($data);

            // Para atualizar, é preciso mandar a diretiva _method com valor "put"
            if($images) 
            {
                $imagesUploaded = [];

                foreach ($images as $image) {
                    $path = $image->store('photos', 'public');
                    $imagesUploaded[] = ['photo' => $path, 'is_thumb' => false];
                }

                $property->photos()->createMany($imagesUploaded);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel atualizado com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    // Remove um imóvel específico
    public function destroy($id)
    {
        try {

            $property = $this->property->findOrFail($id); 
            $property->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel removido com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    // Filtros para imóveis
    public function filters(Request $request)
    {
        $properties = $this->property->newQuery();

        $filters = array_keys($request->all());

        foreach ($filters as $filter) 
        {
            if ($request->has($filter)) 
            {
                $properties->where($filter, $request->input($filter));
            }
        }

        if ($request->has('price-max') || $request->has('price-min')) 
        {
            $properties->where('price', "<=", $request->input('price-max'))
                ->where('price', ">=", $request->input('price-min'));
        }

        return response()->json($properties->get(), 200);
    }

    public function updateSolicitation(Request $request) 
    {

    }

    public function removeSolicitation($id) 
    {
        try {

            $property = auth()->user()->properties()->findOrFail($id);

            Mail::to(env('ADMIN_MAIL'))->send(new RemoveSolicitation(auth()->user(), $property, true));

            return response()->json([
                'data' => [
                    'msg' => 'Solicitação enviada com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    // Aprova um imóvel específico
    public function approveProperty($id) 
    { 
        try {
            
            $property = $this->property->findOrFail($id); 
            $property->update(["confirmed" => 1]);

            $user = $this->user->findOrfail($property['user_id']);
            
            Mail::to(env('ADMIN_MAIL'))->send(new PropertyApproved($user, $property, true));
            Mail::to(env('ADMIN_MAIL'))->send(new PropertyApproved($user, $property, false));

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel aprovado com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function switchUnableProperty($id) 
    {
        try {

            $property = $this->property->findOrFail($id); 

            if($property->unable == 0) {
                $property->update(['unable' => true]);
            } else {
                $property->update(['unable' => false]);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel atualizado com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
