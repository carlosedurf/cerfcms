<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:edit-users');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        $loggedId = intVal(Auth::id());

        return view('admin.users.index', [
            'users' => $users,
            'logguedId' => $loggedId
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'email',
            'password',
            'password_confirmation'
        ]);

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        if($validator->fails()){
            return redirect()->route('users.create')
                    ->withErrors($validator)
                    ->withInput();
        }

        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()->route('users.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if($user){
            return view('admin.users.edit', [
                'user' => $user
            ]);
        }

        return redirect()->route('users.index');
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
        
        $user = User::find($id);

        if($user){

            // 1. Alteração do Nome
            // 2. Alteração do email
            // 2.1 Primeiro, verificamos se o e-mail foi alterado
            // 2.2 Verificamos se o novo email já existe
            // 2.3 Se não existir, nós alteramos
            // 3. Alteração de Senha
            // 3.1 Verifica se o usuário digitou senha
            // 3.2 Verifica se a confirmação esta OK
            // 3.3 Altera a senha

            $data = $request->only([
                'name',
                'email',
                'password',
                'password_confirmation'
            ]);

            $validator = Validator::make([
                'name' => $data['name'],
                'email' => $data['email']
            ], [
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:100'],
            ]);

            $user->name = $data['name'];

            if($user->email != $data['email']){

                $hastEmail = User::where('email', $data['email'])->get();

                if(count($hastEmail) === 0){
                    $user->email = $data['email'];
                }else{
                    $validator->errors()->add('email', __('validation.unique', [
                        'attribute' => 'email'
                    ]));
                }

            }

            if(!empty($data['password'])){

                if(strlen($data['password']) >= 4){
                    if($data['password'] === $data['password_confirmation']){
                        $user->password = Hash::make($data['password']);
                    }else{
                        $validator->errors()->add('password', __('validation.confirmed', [
                        'attribute' => 'password'
                    ]));
                    }
                }else{
                    $validator->errors()->add('password', __('validation.min.string', [
                        'attribute' => 'password',
                        'min' => 4
                    ]));
                }
            }

            if(count( $validator->errors() ) > 0){
                 return redirect()->route('users.edit', [
                    'user' => $id
                ])->withErrors($validator);
            }

            $user->save();

        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loggedId = intVal(Auth::id());

        if($loggedId !== intVal($id)){
            $user = User::find($id);
            $user->delete();
        }

        return redirect()->route('users.index');
    }
}
