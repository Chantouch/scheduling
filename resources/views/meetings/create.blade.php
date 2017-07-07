@extends('layouts.layout')
@section('style')
    <link rel="stylesheet" href="{!! asset('assets/plugins/clockpicker/css/materialize.clockpicker.css') !!}">
    @stop
@section('content')
    <div class="col s12">
        <div class="page-title">Meetings</div>
    </div>
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Input fields</span><br>
                <div class="row">
                    {!! Form::open(array('route' => 'app.meetings.store','method'=>'POST', 'class'=> 'col s12', 'role'=> 'form')) !!}
                    @include('meetings.fields')
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
