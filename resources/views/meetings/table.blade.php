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
            <th>ដំណើរការ</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($meetings as $meeting)
            <tr>
                <td>{!! $i++ !!}</td>
                <td>{!! $meeting->date !!}</td>
                <td>{!! $meeting->time !!}</td>
                <td>{!! $meeting->subject !!}</td>
                <td>{!! $meeting->related_org !!}</td>
                <td>{!! $meeting->location !!}</td>
                <td class="text-center">
                    {{--{!! Form::open(['route' => ['meetings.destroy', $meeting->hashid], 'method' => 'delete', 'class'=>'form-width-70', 'id' => 'action_form']) !!}--}}
                    <div class='btn-group'>
                        <a href="{!! route('app.meetings.show', [$meeting->hashid]) !!}"
                           class='btn btn-default btn-xs'>
                            <i class="material-icons">view_day</i></a>
                        <a href="{!! route('app.meetings.edit', [$meeting->hashid]) !!}"
                           class='btn btn-default btn-xs'>
                            <i class="material-icons">query_builder</i></a>
                        {{--{!! Form::button('<i class="material-icons">info_outline</i>', ['type' => 'button', 'class' => 'btn btn-danger waves-effect waves-light btn-xs delete', 'id' => "delete_btn"]) !!}--}}
                        <button class="btn btn-danger waves-effect waves-light btn-sm delete" type="button"
                                value="{{ $meeting->hashid }}">
                            <i class="material-icons">info_outline</i>
                        </button>
                    </div>
                    {{--{!! Form::close() !!}--}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif