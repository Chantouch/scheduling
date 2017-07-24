<tbody>
<?php $time = 600; ?>
@if(count($meetings))
    @foreach($meetings as $meeting)
        <tr id="{!! $meeting->hashid !!}"
            class="@if($meeting->meeting_date->format('d-m-Y') == date('d-m-Y') && $meeting->start_time <= date('H:i') && $meeting->end_time > date('H:i'))
            {!! 'meeting-now valid' !!}
            @endif
            @if($meeting->end_time < date('H:i') && $meeting->meeting_date == date('d-m-Y')){!! 'finished' !!} @endif">
            <td>
                {!! \app\Helper\Format::khmerFormatMeetingDate($meeting) !!}
            </td>
            <td data-start-time="{!! $meeting->start_time !!}"
                data-end-time="{!! $meeting->end_time !!}">
                {!! $meeting->start_time.' - '.$meeting->end_time !!}
            </td>
            <td>{!! $meeting->subject !!}</td>
            <td>
                @if(!empty($meeting->related_org))
                    {!! $meeting->related_org !!}
                @else
                    --
                @endif
            </td>
            <td>{!! $meeting->location !!}</td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="12">
            <div class="center">
                <p>មិនទាន់មានការប្រជុំនៅឡើយទេ។</p>
            </div>
        </td>
    </tr>
@endif
</tbody>