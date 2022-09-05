<?php

namespace App\Http\Controllers;

use App\Api\ApiMessages;
use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    private $document;

    // Construtor para documento
    public function __construct(Document $document)
    {
        $this->middleware('auth:api');
        $this->document = $document;
    }

    // Lista todos os documentos
    public function index()
    {
        $documents = $this->document->all();

        return response()->json($documents, 200);
    }

    // Cria e guarda um novo documento
    public function store(DocumentRequest $request)
    {
        $data = $request->all();
        $file = $request->file('document');

        try {

            // Verifica se existe algum arquivo em $file, caso sim, guarda no banco
            if($file) 
            {
                $path = $file->store('documents', 'public');

                $data['document'] = $path;
                $this->document->create($data);
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

    // Retorna um documento específico
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

    // Atualiza um documento específico
    public function update(DocumentRequest $request, $id)
    {
        $data = $request->all();
        $file = $request->file('document');

        try {

            // Procura o documento e se achar, atualiza
            $document = $this->document->findOrFail($id);

            $path = $file->store('documents', 'public');
            $data['document'] = $path;

            $document->update($data);

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

    // Remove um documento específico
    public function destroy($documentId)
    {
        try {

            // Procura o documento e se achar, exclui
            $document = $this->document->findOrFail($documentId);

            if($document) 
            {
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

    public function userDocuments()
    {
        try {

            $user = User::findOrFail(auth()->user()->id);

            return response()->json($user->documents, 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
