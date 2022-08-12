<?php

namespace App\Http\Controllers;

use App\Api\ApiMessages;
use App\Models\Property;
use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Mail\NotifyMail;
use App\Mail\PropertyCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\DocBlock\Tags\PropertyRead;

class PropertyController extends Controller
{
    private $property;

    public function __construct(Property $property)
    {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'filters']]);
        $this->property = $property;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorna os imoveis paginados em json
        $property = $this->property->all();
        
        Mail::to(env('ADMIN_MAIL'))->send(new NotifyMail());
 
        if (Mail::failures()) {
           return response()->fail('Sorry! Please try again latter');
        }else{
            return response()->json($property, 200);
        }   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyRequest $request)
    {
        $data = $request->all();
        $images = $request->file('images');

        try {

            $property = $this->property->create($data); // Mass Asignment

            if($images) {
                $imagesUploaded = [];

                foreach ($images as $image) {
                    $path = $image->store('photos', 'public');
                    $imagesUploaded[] = ['photo' => $path, 'is_thumb' => false];
                }

                $property->photos()->createMany($imagesUploaded);
            }

            $user = $this->user->findOrfail($property['user_id']);

            Mail::to("mfelipenovaes@gmail.com")->send(new PropertyCreated($user, $property, true));
            //Mail::to($user->email)->send(new PropertyCreated($visit, $user, $property, false));

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $property = $this->property->with('photos')->findOrFail($id); 

            return response()->json([
                    'data' => $property
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PropertyRequest $request, $id)
    {
        $data = $request->all();
        $images = $request->file('images');

        try {

            $property = $this->property->findOrFail($id); 
            $property->update($data);

            // Para atualizar, é preciso mandar a diretiva _method com valor "put"
            if($images) {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    public function filters(Request $request)
    {
        $properties = $this->property->newQuery();

        $filters = array_keys($request->all());

        foreach ($filters as $filter) {
            if ($request->has($filter)) {
                $properties->where($filter, $request->input($filter));
            }
        }

        if ($request->has('price-max') || $request->has('price-min')) {
            $properties->where('price', "<=", $request->input('price-max'))
                ->where('price', ">=", $request->input('price-min'));
        }

        return response()->json($properties->get(), 200);
    }

    public function updateSolicitation(Request $request) {

    }

    public function approveProperty($id) {
        $property = $this->property->findOrFail($id); 
        $property->update("status", 1);
    }
}
