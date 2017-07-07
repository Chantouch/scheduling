@if(count($missions))
    <table class="bordered">
        <thead class="back_color">
        <tr class="border">
            <th>ល.រ</th>
            <th class="size">កាលបរិច្ឆេទ</th>
            <th class="size">ថ្នាក់ដឹកនាំ</th>
            <th class="size">បេសកកម្ម</th>
            <th class="size">ផ្ទេរសិទ្ធ</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1?>
        @foreach($missions as $mission)
            <tr>
                <td>{!! $i++ !!}</td>
                <td>{!! $mission->start_date.' to '.$mission->end_date !!}</td>
                <td>{!! $mission->leader !!}</td>
                <td>{!! $mission->mission !!}</td>
                <td>{!! $mission->offer_to !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif