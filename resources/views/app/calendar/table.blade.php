@if(count($calendars))
    <div class="col s12 m-t-10" style="display: none;">
        {!! Form::open(['method' => 'GET', 'files'=> true]) !!}
        <div class="col s6">
            {!! Form::label('show', 'Show:') !!}
            <div class="form-group" style="margin-bottom: 0;">
                <div class="form-line">
                    {!! Form::select('show',[10=>10,25=>25,30=>30,40=>40,50=>50] , null, ['class' => 'form-control', 'data-live-search' => 'true']) !!}
                </div>
                @if ($errors->has('show'))
                    <span class="help-block">
                        <strong>{{ $errors->first('show') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col s6">
            {!! Form::label('search', 'Search:') !!}
            <div class="form-group{{ $errors->has('search') ? ' has-error' : '' }}" style="margin-bottom: 0;">
                <div class="form-line">
                    {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Enter your product name']) !!}
                </div>
                @if ($errors->has('search'))
                    <span class="help-block">
                        <strong>{{ $errors->first('search') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <table class="responsive-table bordered">
        <thead class="back_color">
        <tr class="border white-space">
            <th>ល.រ</th>
            <th class="size">កាលបរិច្ឆេទ</th>
            <th class="size">ម៉ោង</th>
            <th class="size">កម្មវត្ថុ</th>
            <th class="size">មន្រ្តីអម/អង្គភាពពាក់ព័ន្ធ</th>
            <th class="size">ទីកន្លែង</th>
            <th>បានបន្ថែម</th>
            <th class="right">ដំណើរការ</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1 ?>
        @foreach($calendars as $calendar)
            <tr id="{!! $calendar->id !!}">
                <th>{!! $i++ !!}</th>
                <th>{!! $calendar->start->dateTime !!}</th>
                <th>{!! $calendar->end->dateTime !!}</th>
                <th>{!! $calendar->summary !!}</th>
                <th>
                    @if(!empty($calendar->attendees))
                        @foreach($calendar->attendees as $attendee)
                            {!! $attendee->displayName !!},
                        @endforeach
                    @endif
                </th>
                <th>{!! $calendar->location !!}</th>
                <th>{!! $calendar->created !!}</th>
                <td class="right">
                    {{--{!! Form::open(['route' => ['meetings.destroy', $meeting->hashid], 'method' => 'delete', 'class'=>'form-width-70', 'id' => 'action_form']) !!}--}}
                    <div class='btn-group'>
                        <a href="{!! $calendar->htmlLink !!}"
                           class='btn btn-floating waves-effect waves-light green tooltipped' data-position="top"
                           data-delay="50" data-tooltip="ចុច ដើម្បីមើល" target="_blank">
                            <i class="material-icons">remove_red_eye</i></a>
                        <a href="{!! route('app.gcalendars.edit', [$calendar->id]) !!}"
                           class='btn btn-floating waves-effect waves-light tooltipped' data-position="top"
                           data-delay="50" data-tooltip="ចុច ដើម្បីកែប្រែ">
                            <i class="material-icons">mode_edit</i></a>
                        {{--{!! Form::button('<i class="material-icons">info_outline</i>', ['type' => 'button', 'class' => 'btn btn-danger waves-effect waves-light btn-xs delete', 'id' => "delete_btn"]) !!}--}}
                        <button class="btn btn-floating red waves-effect waves-light delete tooltipped" type="button"
                                value="{{ $calendar->id }}" data-position="top" data-delay="50"
                                data-tooltip="ចុច ដើម្បីលុប">
                            <i class="material-icons">delete</i>
                        </button>
                        {{--<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="I am tooltip">top</a>--}}
                    </div>
                    {{--{!! Form::close() !!}--}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif