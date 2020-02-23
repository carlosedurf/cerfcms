@extends('adminlte::page')

@section('plugins.Chartjs', true)

@section('title', 'Dashboard')

@section('content_header')
    <div class="row">
        <div class="col-md-9">
            <h1>Dashboard</h1>
        </div>
        <div class="col-md-3">
            <form action="{{route('admin')}}" id="form-search" method="POST">
                @csrf
                <select name="ultimos" id="ultimos" class="form-control">
                    <option value="30">Últimos 30 dias</option>
                    <option value="60">Últimos 60 dias</option>
                </select>
            </form>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$visitsCount}}</h3>
                    <p>Acessos</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-eye"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$onlineCount}}</h3>
                    <p>Usuários Online</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-heart"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{$pageCount}}</h3>
                    <p>Páginas</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-sticky-note"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$userCount}}</h3>
                    <p>Usuários</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-user"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Páginas mais visitadas</h3>
                </div>
                <div class="card-body">
                    <canvas id="pagePie"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Avisos</h3>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Reunião no dia 01/03/2020</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<script>
window.onload = function(){
    let ctx = document.getElementById('pagePie').getContext('2d');

    window.pagePie = new Chart(ctx, {
        type:'pie',
        data:{
            datasets:[{
                data:{{ $pageValues }},
                backgroundColor: '#00F'
            }],
            labels:{!! $pageLabels !!}
        },
        options:{
            reponsive:true,
            legend:{
                display:false
            }
        }
    });

    document.getElementById('ultimos').addEventListener('change', function(){
        document.getElementById('form-search').submit();
    });
}
</script>
@endsection
