<?php

namespace App\Http\Controllers;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorna os imoveis paginados em json
        $users = $this->user->all();

        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();

        // Verificando diretamente pelo controller se a senha foi digitada
        if(!$request->has('password') || !$request->get('password')) {
            $message = new ApiMessages('É necessário informar uma senha.');
            return response()->json($message->getMessage(), 401);
        }

        try {

            $data['password'] = bcrypt($data['password']); // Incripta a senha do usuário
            //$data['password'] = Hash::make($data['password']);

            $user = $this->user->create($data); // Mass Asignment

            $credentials = [
                'email' => $request['email'],
                'password' => $request['password'],
            ];

            if (! $token = auth()->attempt($credentials)) {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $data = $request->all();

        // Verificando diretamente pelo controller se a senha é valida
        if($request->has('password') && $request->get('password')) 
        {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']); // remove do update
        }

        try {

            $user = $this->user->findOrFail($id); 
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
}

