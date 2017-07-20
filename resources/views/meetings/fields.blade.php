<div class="input-field col s4{!! $errors->has('meeting_date') ? ' invalid' : '' !!}">
    {!! Form::text('meeting_date', null, ['class'=> 'validate datepicker','placeholder' => 'ថ្ងៃខែឆ្នាំ']) !!}
    <label for="meeting_date">កាលបរិច្ឆេទ</label>
    @if($errors->has('meeting_date'))
        <label id="meeting_date-error" class="error" for="meeting_date">
            <strong>{!! $errors->first('meeting_date') !!}</strong>
        </label>
    @endif
</div>

<div class="input-field col s4">
    {!! Form::text('start_time', null, ['class' => 'validate timepicker', 'placeholder' => 'ម៉ោង']) !!}
    <label for="time">ម៉ោងចាប់ផ្តើម</label>
    @if($errors->has('start_time'))
        <label id="start_time-error" class="error" for="start_time">
            <strong>{!! $errors->first('start_time') !!}</strong>
        </label>
    @endif
</div>

<div class="input-field col s4">
    {!! Form::text('end_time', null, ['class' => 'validate timepicker', 'placeholder' => 'ម៉ោង']) !!}
    <label for="time">ម៉ោងបញ្ចប់</label>
    @if($errors->has('end_time'))
        <label id="end_time-error" class="error" for="end_time">
            <strong>{!! $errors->first('end_time') !!}</strong>
        </label>
    @endif
</div>

<div class="input-field col s12">
    {!! Form::text('subject', null, ['class'=>'validate', 'placeholder' => '']) !!}
    <label for="subject">កម្មវត្ថុ</label>
    @if($errors->has('subject'))
        <label id="subject-error" class="error" for="subject">
            <strong>{!! $errors->first('subject') !!}</strong>
        </label>
    @endif
</div>

<div class="input-field col s12">
    {!! Form::text('related_org', null, ['class' => 'validate', 'placeholder' => '']) !!}
    <label for="related_org">មន្រ្តីអម/អង្គភាពពាក់ព័ន្ធ</label>
    @if($errors->has('related_org'))
        <label id="related_org-error" class="error" for="related_org">
            <strong>{!! $errors->first('related_org') !!}</strong>
        </label>
    @endif
</div>

<div class="input-field col s12">
    {!! Form::text('location', null, ['class'=>'validate', 'placeholder' => '']) !!}
    <label for="location">ទិកន្លែង</label>
    @if($errors->has('location'))
        <label id="location-error" class="error" for="location">
            <strong>{!! $errors->first('location') !!}</strong>
        </label>
    @endif
</div>

<div class="input-field col s12">
    <div class="actions clearfix">
        {{--{!! Form::submit('រក្សាទុក', ['class'=>'waves-effect waves-blue btn blue']) !!}--}}
        <button type="submit" class="waves-effect waves-blue btn blue">រក្សាទុក</button>
        <a href="{!! route('app.meetings.index') !!}" class="waves-effect waves-blue btn red">បោះបង់</a>
    </div>
</div>