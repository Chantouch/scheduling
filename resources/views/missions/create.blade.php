@extends('layouts.layout')
@section('style')
    <link rel="stylesheet" href="{!! asset('assets/plugins/clockpicker/css/materialize.clockpicker.css') !!}">
    @stop
@section('content')
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <div class="col s12">
                    <span class="card-title">បេសកកម្ម</span>
                    <hr>
                    <br>
                </div>
                <div class="row">
                    {!! Form::open(array('route' => 'app.missions.store','method'=>'POST', 'class'=> '', 'role'=> 'form')) !!}
                    @include('missions.fields')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{!! asset('assets/plugins/clockpicker/js/materialize.clockpicker.js') !!}"></script>
    <script src="{!! asset('assets/js/pages/form_elements.js') !!}"></script>
@stop
