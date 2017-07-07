@extends('layouts.layout')

@section('content')
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <div class="col s6 l6">
                        <h3 class="card-title">កម្មវិធីប្រជុំរបស់ឯកឧត្តមរដ្ឋមន្រ្តី</h3>
                    </div>
                    <div class="col s6 l6">
                        <div class="right m-t-lg">
                            <a href="{!! route('app.meetings.create') !!}" class="waves-effect waves-blue btn-flat">Add more</a>
                        </div>
                    </div>
                </div>
                @include('meetings.table')
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(".delete").click(function () {
            let id = $(this).val();
            let $con = confirm('Are you sure to delete this image');
            if ($con) {
                $.ajax({
                    url: "/app/meetings/" + id,
                    data: {"_token": "{{ csrf_token() }}"},
                    type: 'DELETE',
                    success: function (result) {
                        console.log(result);
                    }
                });
                $(this).closest("tr").fadeOut(800);
                //$(this).closest("tr").remove();
            }
        });
    </script>
@stop
