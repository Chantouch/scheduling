@if(count($missions))
    <table class="bordered">
        <thead class="back_color">
        <tr class="border">
            <th>ល.រ</th>
            <th class="size">កាលបរិច្ឆេទ</th>
            <th class="size">ថ្នាក់ដឹកនាំ</th>
            <th class="size">បេសកកម្ម</th>
            <th class="size">ផ្ទេរសិទ្ធ</th>
            <th>ដំណើរការ</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1?>
        @foreach($missions as $mission)
            <tr id="{!! $mission->hashid !!}">
                <td>{!! $i++ !!}</td>
                <td>{!! $mission->start_date.' to '.$mission->end_date !!}</td>
                <td>{!! $mission->leader !!}</td>
                <td>{!! $mission->mission !!}</td>
                <td>{!! $mission->offer_to !!}</td>
                <td class="text-center">
                    {{--{!! Form::open(['route' => ['meetings.destroy', $mission->hashid], 'method' => 'delete', 'class'=>'form-width-70', 'id' => 'action_form']) !!}--}}
                    <div class='btn-group'>
                        <a href="{!! route('app.missions.show', [$mission->hashid]) !!}"
                           class='btn btn-floating green'>
                            <i class="material-icons">remove_red_eye</i></a>
                        <a href="{!! route('app.missions.edit', [$mission->hashid]) !!}"
                           class='btn btn-floating'>
                            <i class="material-icons">mode_edit</i></a>
                        {{--{!! Form::button('<i class="material-icons">info_outline</i>', ['type' => 'button', 'class' => 'btn btn-danger waves-effect waves-light btn-xs delete', 'id' => "delete_btn"]) !!}--}}
                        <button class="btn btn-floating waves-effect waves-light delete red" type="button"
                                value="{{ $mission->hashid }}">
                            <i class="material-icons">delete</i>
                        </button>
                    </div>
                    {{--{!! Form::close() !!}--}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif