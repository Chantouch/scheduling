<tbody>
@if(count($missions))
    @foreach($missions as $mission)
        <tr id="{!! $mission->hashid !!}">
            <td class="white-space">
                {!! \app\Helper\Format::khmerFormatMissionDate($mission) !!}
            </td>
            <td>{!! $mission->leader !!}</td>
            <td>{!! $mission->mission !!}</td>
            <td>
                @if(!empty($mission->offer_to))
                    {!! $mission->offer_to !!}
                @else
                    --
                @endif
            </td>
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
