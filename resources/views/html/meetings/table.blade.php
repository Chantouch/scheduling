@if(count($meetings))
    <table class="bordered">
        <thead class="back_color">
        <tr class="border">
            <th class="size">កាលបរិច្ឆេទ</th>
            <th class="size">ម៉ោង</th>
            <th class="size">កម្មវត្ថុ</th>
            <th class="size">មន្រ្តីអម/អង្គភាពពាក់ព័ន្ធ</th>
            <th class="size">ទីកន្លែង</th>
        </tr>
        </thead>
        <tbody>
        @foreach($meetings as $meeting)
            <tr>
                <td>{!! $meeting->date !!}</td>
                <td>{!! $meeting->time !!}</td>
                <td>{!! $meeting->subject !!}</td>
                <td>{!! $meeting->related_org !!}</td>
                <td>{!! $meeting->location !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif