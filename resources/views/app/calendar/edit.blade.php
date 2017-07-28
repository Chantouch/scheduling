@extends('layouts.layout')
@section('style')
    <link rel="stylesheet" href="{!! asset('assets/plugins/clockpicker/css/materialize.clockpicker.css') !!}">
    @stop
@section('content')
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col s12">
                        <span class="card-title">កិច្ចប្រជុំ</span>
                        <hr>
                        <br>
                    </div>
                    {!! Form::model($event, ['method' => 'PATCH','route' => ['app.gcalendars.update', $event->id], 'class' => '', 'role'=> 'form']) !!}
                    @include('app.calendar.fields')
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
