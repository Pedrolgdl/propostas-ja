<?php

namespace App\Http\Controllers;

use App\Api\ApiMessages;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    private $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorna os documentos
        $documents = $this->document->all();

        return response()->json($documents, 200);
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
        $file = $request->file('document');

        try {

            if($file) {
                $path = $file->store('documents', 'public');

                $data['document'] = $path;
                $document = $this->document->create($data); // Mass Asignment
            }

            return response()->json([
                'data' => [
                    'msg' => 'Documento cadastrado com sucesso.'
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

            $document = $this->document->findOrFail($id); 

            return response()->json([
                    'data' => $document
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
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
        $data = $request->all();
        $file = $request->file('document');

        try {

            $document = $this->document->findOrFail($id);
            // $oldDocument = $this->document->find($id);

            // // excluir documento antigo
            // Storage::disk('public')->delete($oldDocument->document);
            // $oldDocument->delete();

            $path = $file->store('documents', 'public');
            $data['document'] = $path;

            $document->update($data); // Mass Asignment

            return response()->json([
                'data' => [
                    'msg' => 'Documento atualizado com sucesso.'
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
    public function destroy($documentId)
    {
        try {

            $document = $this->document->find($documentId);

            if($document) {
                Storage::disk('public')->delete($document->document);
                $document->delete();
            }

            return response()->json([
                'data' => [
                    'msg' => 'Documento removido com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
