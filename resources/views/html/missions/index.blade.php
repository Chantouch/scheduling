@extends('layouts.app')

@section('content')
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <div class="col s3 m3 l3">
                    <div class="right">
                        <img src="{!! asset('assets/images/mef.png') !!}" class="responsive-img" width="100">
                    </div>
                </div>
                <div class="col s6 m6 l6 center">
                    <div class="main">
                        <h5>លេខាធិការដ្ឋាន នៃអគ្គនាយកដ្ឋានរតនាគាជាតិ</h5>
                    </div>
                    <div class="takteng">
                        <img src="{!! asset('assets/images/takteng.png') !!}" class="responsive-img" width="180">
                    </div>
                    <div class="mains">
                        <h5>បេសកកម្ម របស់ឯកឧត្តមបណ្ឌិតអគ្គនាយក</h5>
                    </div>
                </div>
                <div class="col s3 m3 l3">
                    <div class="dates center">
                        <h5>
                            ថ្ងៃ<span id="day_of_week">loading ...</span>
                            ទី<span id="day">loading ...</span> ខែ<span id="month">loading ...</span>
                            ឆ្នាំ<span id="year">loading ...</span>
                        </h5>
                        <div id="clock" class="clock">loading ...</div>
                    </div>
                </div>
                <table class="bordered" id="mission-data-reload">
                    <thead class="back_color">
                    <tr class="border">
                        <th class="size">កាលបរិច្ឆេទ</th>
                        <th class="size">ថ្នាក់ដឹកនាំ</th>
                        <th class="size">បេសកកម្ម</th>
                        <th class="size">ផ្ទេរសិទ្ធ</th>
                    </tr>
                    </thead>
                    @include('html.missions.table')
                </table>
            </div>
            <div class="ajax-load text-center" style="display:none">
                <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{!! asset('js/socket.io.js') !!}"></script>
    <script src="{!! asset('js/mission.js') !!}"></script>
    <script>

    </script>
@stop
