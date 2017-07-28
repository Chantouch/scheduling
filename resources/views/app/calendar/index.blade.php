@extends('layouts.layout')
@section('style')
    <link rel="stylesheet" href="{!! asset('assets/plugins/sweetalert/sweetalert.css') !!}">
    <link rel="stylesheet" href="{!! asset('css/style.css') !!}">
@stop
@section('content')
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col s6 l6">
                        <h3 class="card-title">កម្មវិធីប្រជុំថ្នាក់ដឹកនាំនិងមន្ត្រី អគ្គ.រតន</h3>
                    </div>
                    {{--<div class="col s6 l6">--}}
                        {{--<div class="right m-t-lg">--}}
                            {{--<a href="{!! route('app.gcalendars.create') !!}" class="waves-effect waves-blue btn">--}}
                                {{--បន្ថែមថ្មី--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
                @include('app.calendar.table')
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{!! asset('assets/plugins/sweetalert/sweetalert.min.js') !!}"></script>
    <script>
        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            let id = $(this).val();
            let route = '/app/gcalendars/' + id;
            let token = {'X-CSRF-TOKEN': $("[name='_token']:first").val()};
            swal({
                title: "លោកអ្នកកំពុងលុប កិច្ចប្រជុំ",
                text: "តើលោកអ្នកចង់លុបបេសកកម្មនេះមែនទេ? ប៉ុន្តែលោកអ្នកនៅតែអាចទាញយកមកវិញបាន។",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                confirmButtonText: "លុប",
                cancelButtonText: "បោះបង់",
                confirmButtonColor: "#ec6c62"
            }, function () {
                $.ajax({
                    type: "DELETE",
                    url: route,
                    headers: token
                }).done(function (data) {
                    swal("កិច្ចប្រជុំ បានលុបដោយជោគជ័យ", data, "success");
                    setTimeout(function () {
                        $('table.bordered').find('tr#' + id).fadeOut('slow');
                    }, 1500);
                }).error(function (data) {
                    swal("Oops", data, "error");
                });
            });
        });
    </script>
@stop
