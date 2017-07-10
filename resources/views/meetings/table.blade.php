@if(count($meetings))
    <table class="bordered">
        <thead class="back_color">
        <tr class="border">
            <th>ល.រ</th>
            <th class="size">កាលបរិច្ឆេទ</th>
            <th class="size">ម៉ោង</th>
            <th class="size">កម្មវត្ថុ</th>
            <th class="size">មន្រ្តីអម/អង្គភាពពាក់ព័ន្ធ</th>
            <th class="size">ទីកន្លែង</th>
            <th class="right">ដំណើរការ</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($meetings as $meeting)
            <tr id="{!! $meeting->hashid !!}">
                <td>{!! $i++ !!}</td>
                <td>{!! $meeting->date !!}</td>
                <td>{!! $meeting->time !!}</td>
                <td>{!! $meeting->subject !!}</td>
                <td>{!! $meeting->related_org !!}</td>
                <td>{!! $meeting->location !!}</td>
                <td class="right">
                    {{--{!! Form::open(['route' => ['meetings.destroy', $meeting->hashid], 'method' => 'delete', 'class'=>'form-width-70', 'id' => 'action_form']) !!}--}}
                    <div class='btn-group'>
                        <a href="{!! route('app.meetings.show', [$meeting->hashid]) !!}"
                           class='btn btn-floating waves-effect waves-light green'>
                            <i class="material-icons">remove_red_eye</i></a>
                        <a href="{!! route('app.meetings.edit', [$meeting->hashid]) !!}"
                           class='btn btn-floating waves-effect waves-light'>
                            <i class="material-icons">mode_edit</i></a>
                        {{--{!! Form::button('<i class="material-icons">info_outline</i>', ['type' => 'button', 'class' => 'btn btn-danger waves-effect waves-light btn-xs delete', 'id' => "delete_btn"]) !!}--}}
                        <button class="btn btn-floating red waves-effect waves-light delete" type="button"
                                value="{{ $meeting->hashid }}">
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