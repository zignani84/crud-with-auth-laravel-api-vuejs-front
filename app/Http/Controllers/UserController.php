<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:api'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = User::all();
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), User::users_rules());
            $name = null;

            if($request->avatar){

                $name = time().'.' . explode('/', explode(':', substr($request->avatar, 0, strpos($request->avatar, ';')))[1])[1];
                Image::make($request->avatar)->save(public_path('img/profile/').$name);
                $request->merge(['avatar' => $name]);

            }

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }

            $response = User::create(array_merge(
                $validator->validated(),
                [
                    'password' => bcrypt($request->password),
                    'avatar' => $name
                ]
            ));

            return response()->json([
                'message'     => 'Usuário cadastrado com sucesso!',
                'success' => $response
            ], 201);
        } catch (ModelNotFoundException $e) {
            response()->json($e);
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
            $response = User::findOrFail($id);

            if(!$response) {
                return response()->json([
                    'message' => 'Registro não encontrado.',
                ], 404);
            }
    
            return response()->json([
                'success' => $response
            ]);
        } catch (ModelNotFoundException $e){
            response()->json($e);
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
        try {
            $response = User::findOrFail($id);

            if($request->avatar && $response->avatar == null){

                $name = time().'.' . explode('/', explode(':', substr($request->avatar, 0, strpos($request->avatar, ';')))[1])[1];
                Image::make($request->avatar)->save(public_path('img/profile/').$name);
                $request->merge(['avatar' => $name]);
            } else {
                $request->request->remove('avatar');
            }

            $response->fill($request->all());

            $validator = Validator::make($response->toArray(), User::users_edit_rules());

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }

            $response->save();

            return response()->json([
                'message'     => 'Usuário atualizado com sucesso!',
                'success'     => $response
            ]);
        } catch (ModelNotFoundException $e) {
            response()->json($e);
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
            $response = User::findOrFail($id);

            if(!$response) {
                return response()->json([
                    'message' => 'Registro não encontrado.',
                ], 404);
            }
    
            $response->delete();

            return response()->json([
                'message' => 'Usuário deletado com sucesso!'
            ]);
        } catch (ModelNotFoundException $e) {
            response()->json($e);
        }
    }
}
