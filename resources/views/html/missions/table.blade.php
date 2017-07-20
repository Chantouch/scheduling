<tbody>
@if(count($missions))
    @foreach($missions as $mission)
        <tr id="{!! $mission->hashid !!}">
            <td>{!! $mission->start_date.' - '.$mission->end_date !!}</td>
            <td>{!! $mission->leader !!}</td>
            <td>{!! $mission->mission !!}</td>
            <td>{!! $mission->offer_to !!}</td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="12">
            <div class="center">
                <p>មិនទាន់មានបេសកកម្មនៅឡើយទេ។</p>
            </div>
        </td>
    </tr>
@endif
</tbody>
