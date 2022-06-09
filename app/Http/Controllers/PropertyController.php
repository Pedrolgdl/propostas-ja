<?php

namespace App\Http\Controllers;

use App\Api\ApiMessages;
use App\Models\Property;
use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;

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
        $photos = $request->file('photos');

        try {

            $property = $this->property->create($data); // Mass Asignment

            if($photos) {
                $photosUploaded = [];

                foreach ($photos as $photo) {
                    // Salvando no drive public
                    $path = $photo->store('photos', 'public');
                    $photosUploaded[] = ['photo' => $path, 'is_thumb' => false];
                }

                $property->photos()->createMany($photosUploaded);
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
        $photos = $request->file('photos');

        try {

            $property = $this->property->findOrFail($id); 
            $property->update($data);

            // Para atualizar, é preciso mandar a diretiva _method com valor "put"
            if($photos) {
                $photosUploaded = [];

                foreach ($photos as $photo) {
                    // Salvando no drive public
                    $path = $photo->store('photos', 'public');
                    $photosUploaded[] = ['photo' => $path, 'is_thumb' => false];
                }

                $property->photos()->createMany($photosUploaded);
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
}
