@extends('adminlte::page')

@section('title', 'Novo Usuário')

@section('content_header')
    <h1>Novo Usuário</h1>
    <hr>
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

<div class="card">
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="post" class="form-horizontal">
            @csrf

            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Nome Completo</label>
                <div class="col-sm-10">
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">E-mail</label>
                <div class="col-sm-10">
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Senha</label>
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
                        <input type="submit" value="Cadastrar" class="btn btn-success">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

    

@endsection
