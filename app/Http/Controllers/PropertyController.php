<?php

namespace App\Http\Controllers;

use App\Api\ApiMessages;
use App\Models\Property;
use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\PropertyRead;

class PropertyController extends Controller
{
    private $property;

    public function __construct(Property $property)
    {
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

        return response()->json($property, 200);
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

        if ($request->has('type')) {
            $properties->where('type', $request->input('type'));
        }

        if ($request->has('city')) {
            $properties->where('city', $request->input('city'));
        }

        if ($request->has('neighborhood')) {
            $properties->where('neighborhood', $request->input('neighborhood'));
        }

        if ($request->has('number_rooms')) {
            $properties->where('number_rooms', $request->input('number_rooms'));
        }

        if ($request->has('furnished')) {
            $properties->where('furnished', $request->input('furnished'));
        }

        if ($request->has('accepts_pet')) {
            $properties->where('accepts_pet', $request->input('accepts_pet'));
        }

        if ($request->has('garage')) {
            $properties->where('garage', $request->input('garage'));
        }

        if ($request->has('number_bathrooms')) {
            $properties->where('number_bathrooms', $request->input('number_bathrooms'));
        }

        if ($request->has('price-max') || $request->has('price-min')) {
            $properties->where('price', "<=", $request->input('price-max'))
                ->where('price', ">=", $request->input('price-min'));
        }

        return response()->json($properties->get(), 200);
    }
}
