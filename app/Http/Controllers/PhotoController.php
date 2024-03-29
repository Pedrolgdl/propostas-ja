<?php

namespace App\Http\Controllers;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    private $photo;

    // Construtor para foto
    public function __construct(Photo $photo)
    {
        $this->middleware('auth:api');
        $this->photo = $photo;
    }

    // Coloca uma imagem como thumb
    public function setThumb($photoId, $propertyId)
    {
        try {

            $image = $this->photo->where('property_id', $propertyId)->where('is_thumb', true);
            
            if($image->count()) $image->first()->update(['is_thumb' => false]);

            $image = $this->photo->find($photoId);
            $image->update(['is_thumb' => true]);

            return response()->json([
                'data' => [
                    'msg' => 'Thumb atualizada com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    // Remove uma imagem específica
    public function remove($photoId)
    {
        try {

            $image = $this->photo->find($photoId);

            if($image) 
            {
                Storage::disk('public')->delete($image->photo);
                $image->delete();
            }

            return response()->json([
                'data' => [
                    'msg' => 'Foto removida com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
