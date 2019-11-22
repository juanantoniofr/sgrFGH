@extends('layout')

@section('head')
<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
<style>
  
    #font-lato {
        text-align: center;
        vertical-align: middle;
        font-weight: 100;
        font-family: 'Lato';
        font-size:56px;
        font-style: italic;
        color: #B0BEC5;
    }

</style>
@stop

@section('title')
    SGR: inicio
@stop



@section('content')
<div class = "container">
        
       
      
      
        <p id = "font-lato">Sistema de Gestión de Reservas<br /> 
            {{Config::get('options.nombreSitio')}}</p>
        
        <div class="col-md-8 col-md-offset-2"  >
        {{ Form::open(['url' => 'login']) }}

            @if(Session::has('error_message'))
                {{ Session::get('error_message') }}
            @endif

            <h2>Formulario de acceso</h2>
            <div class="form-group">
                {{ Form::label('username', 'Username') }}
                {{ Form::text('username') }}
            </div>
            <div class="form-group">
                {{ Form::label('password', 'Password') }}
                {{ Form::password('password') }}
            </div>
            <div class="form-group">
                <label>
                    {{ Form::checkbox('remember', true) }} Remember me
                </label>
            </div>
            <div class="col-md-4 form-group">    
                {{ Form::submit('Log in', ['class' => 'btn btn-primary btn-block']) }}
            </div>
    
        {{ Form::close() }}
       </div>
    
    </div>
@stop 