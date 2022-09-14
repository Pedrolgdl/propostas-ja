<?php

namespace App\Http\Controllers;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private $user;

    
    // Construtor para usuário
    public function __construct(User $user)
    {
        $this->middleware('auth:api', ['except' => ['store']]);
        $this->middleware('role', ['except' => ['store', 'favorite', 'unfavorite', 'showFavorite', 'update']]);

        $this->user = $user;
    }

    // Lista todos os usuários
    public function index()
    {
        $users = DB::select('SELECT DISTINCT u.userPhoto, u.name, u.surname, COUNT(*) FROM users AS u INNER JOIN properties AS p ON u.id = p.user_id GROUP BY u.userPhoto, u.name, u.surname ORDER BY u.name');

        return response()->json($users, 200);
    }

    // Cria e guarda um novo usuário
    public function store(UserRequest $request)
    {
        $data = $request->all();
        $photo = $request->file('userPhoto');

        // Verificando diretamente pelo controller se a senha foi digitada
        if(!$request->has('password') || !$request->get('password')) 
        {
            $message = new ApiMessages('É necessário informar uma senha.');
            return response()->json($message->getMessage(), 401);
        }

        try {

            // Incripta a senha do usuário
            $data['password'] = bcrypt($data['password']); 

            // Verifica se existe foto de usuário. Se sim, atualiza o campo "userPhoto" com o caminho
            if ($photo) 
            {
                $path = $photo->store('UserPhoto', 'public');

                $data['userPhoto'] = $path;
            }

            $user = $this->user->create($data);

            $credentials = [
                'email' => $request['email'],
                'password' => $request['password'],
            ];

            if (! $token = auth()->attempt($credentials)) 
            {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return response()->json([
                'token' => $token,
                'role' => $user['role'],
                'message' => 'Usuário cadastrado com sucesso.'
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    // Retorna um usuário específico
    public function show($id)
    {
        try {

            $user = $this->user->findOrFail($id); 

            return response()->json([
                    'data' => $user
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    // Atualiza um usuário específico
    public function update(UserRequest $request)
    {
        $data = $request->all();
        $photo = $request->file('userPhoto');

        // Verificando diretamente pelo controller se a senha é valida
        if($request->has('oldPassword') && $request->get('oldPassword') && $request->get('newPassword') && $request->get('newPassword')) 
        {
            $inputOldPassword = $data['oldPassword'];
            $user = $this->user->findOrFail(auth()->user()->id); 
            $databasePassword = $user['password'];

            // Verifica se a senha antiga é igual a do banco
            if (Hash::check($inputOldPassword, $databasePassword))
            {
                $data['newPassword'] = bcrypt($data['newPassword']);

                DB::table('users')->where('id', auth()->user()->id)->update(['password' => $data['newPassword']]);

                return response()->json([
                    'data' => [
                        'msg' => 'Senha atualizada com sucesso.'
                    ]
                ], 200);

            } else {
                return response()->json([
                    'data' => [
                        'msg' => 'Senha incorreta.'
                    ]
                ], 400);
            }
        } else {
            unset($data['password']); // remove do update
        }

        try {

            $user = $this->user->findOrFail(auth()->user()->id); 

            // Verifica se existe foto de usuário. Se sim, atualiza o campo "userPhoto" com o caminho
            if ($photo) 
            {
                // Caso já possua uma foto, exclui a antiga
                if ($user['userPhoto']) 
                {
                    Storage::disk('public')->delete($user['userPhoto']);
                }

                $path = $photo->store('UserPhoto', 'public');

                $data['userPhoto'] = $path;
            }

            $user->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'Usuário atualizado com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    // Remove um usuário específico
    public function destroy($id)
    {
        try {

            $user = $this->user->findOrFail($id); 
            $user->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Usuário removido com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    // Função para favoritar
    public function favorite($propertyId)
    {
        try {

            $user = User::findOrFail(auth()->user()->id);
            $property = Property::findOrFail($propertyId);

            // Adiciona no final da lista de favoritos
            $user->favorites()->attach($property);

            return response()->json([
                'data' => [
                    'msg' => 'Favorito adicionado com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    // Função para remover favorito
    public function unfavorite($propertyId)
    {
        try {

            $user = User::findOrFail(auth()->user()->id);
            $property = Property::findOrFail($propertyId);

            // Remove da lista de favoritos
            $user->favorites()->detach($property);

            return response()->json([
                'data' => [
                    'msg' => 'Favorito removido com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    // Função para listar favoritos
    public function showFavorite()
    {
        try {

            $user = User::findOrFail(auth()->user()->id);

            return response()->json($user->favorites, 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    // Função para enviar proposta
    public function proposal($propertyId)
    {
        try {

            $user = User::findOrFail(auth()->user()->id);
            $property = Property::findOrFail($propertyId);

            // Adiciona no final da lista de propostas
            $user->proposals()->attach($property);

            return response()->json([
                'data' => [
                    'msg' => 'Proposta adicionada com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    // Função para remover posposta
    public function removeProposal($propertyId)
    {
        try {

            $user = User::findOrFail(auth()->user()->id);
            $property = Property::findOrFail($propertyId);

            // Remove da lista de propostas
            $user->proposals()->detach($property);

            return response()->json([
                'data' => [
                    'msg' => 'Proposta removida com sucesso.'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    // Função para listar propostas
    public function showProposal()
    {
        try {

            $user = User::findOrFail(auth()->user()->id);

            return response()->json($user->proposals, 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    // Função para remover foto de perfil
    public function removeUserPhoto($userId)
    {
        try {

            $user = $this->user->findOrFail($userId);

            if ($user['userPhoto']) 
            {
                Storage::disk('public')->delete($user['userPhoto']);
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

