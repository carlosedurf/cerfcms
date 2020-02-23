@extends('adminlte::page')

@section('title', 'Meu Perfil')

@section('content_header')
    <h1>Meu Perfil</h1>
@endsection

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            <h5><i class="icon fas fa-ban"></i> Ocorreu um erro.</h5>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('warning'))
<div class="alert alert-success">
    {{ session('warning') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('profile.save', ['user'=>$user->id]) }}" method="post" class="form-horizontal">
            @method('PUT')
            @csrf

            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Nome Completo</label>
                <div class="col-sm-10">
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">E-mail</label>
                <div class="col-sm-10">
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Nova Senha</label>
                <div class="col-sm-10">
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                </div>
            </div>

            <div class="form-group row">
                <label for="password_confirmation" class="col-sm-2 col-form-label">Senha Novamente</label>
                <div class="col-sm-10">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password') is-invalid @enderror">
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <input type="submit" value="Salvar" class="btn btn-success">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
