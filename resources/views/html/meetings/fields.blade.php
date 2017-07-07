<div class="row">
    <div class="input-field col s6{!! $errors->has('name') ? ' invalid' : '' !!}">
        {!! Form::text('date', null, ['class'=> 'validate datepicker','placeholder' => 'ថ្ងៃខែឆ្នាំ']) !!}
        <label for="date">Date</label>
        @if($errors->has('date'))
            <label id="date-error" class="error" for="date">
                <strong>{!! $errors->first('date') !!}</strong>
            </label>
        @endif
    </div>

    <div class="input-field col s6">
        {!! Form::text('time', null, ['class' => 'validate timepicker', 'placeholder' => 'ម៉ោង']) !!}
        <label for="time">Time</label>
        @if($errors->has('time'))
            <label id="time-error" class="error" for="time">
                <strong>{!! $errors->first('time') !!}</strong>
            </label>
        @endif
    </div>

    <div class="input-field col s12">
        {!! Form::text('subject', null, ['class'=>'validate', 'placeholder' => '']) !!}
        <label for="subject">Subject</label>
        @if($errors->has('subject'))
            <label id="subject-error" class="error" for="subject">
                <strong>{!! $errors->first('subject') !!}</strong>
            </label>
        @endif
    </div>

    <div class="input-field col s12">
        {!! Form::text('related_org', null, ['class' => 'validate', 'placeholder' => '']) !!}
        <label for="related_org">Related organization</label>
        @if($errors->has('related_org'))
            <label id="related_org-error" class="error" for="related_org">
                <strong>{!! $errors->first('related_org') !!}</strong>
            </label>
        @endif
    </div>

    <div class="input-field col s12">
        {!! Form::text('location', null, ['class'=>'validate', 'placeholder' => '']) !!}
        <label for="location">Location</label>
        @if($errors->has('location'))
            <label id="location-error" class="error" for="location">
                <strong>{!! $errors->first('location') !!}</strong>
            </label>
        @endif
    </div>

    <div class="input-field col s12">
        <div class="actions clearfix">
            {!! Form::submit('Save', ['class'=>'waves-effect waves-blue btn-flat']) !!}
            <a href="{!! route('app.meetings.index') !!}" class="waves-effect waves-blue btn-flat">Cancel</a>
        </div>
    </div>
</div>