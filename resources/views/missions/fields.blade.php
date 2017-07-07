<div class="row">
    <div class="input-field col s6{!! $errors->has('name') ? ' invalid' : '' !!}">
        {!! Form::text('start_date', null, ['class'=> 'validate datepicker','placeholder' => 'ថ្ងៃខែឆ្នាំ']) !!}
        <label for="start_date">Start date</label>
        @if($errors->has('start_date'))
            <label id="start_date-error" class="error" for="start_date">
                <strong>{!! $errors->first('start_date') !!}</strong>
            </label>
        @endif
    </div>

    <div class="input-field col s6">
        {!! Form::text('end_date', null, ['class' => 'validate datepicker', 'placeholder' => 'ម៉ោង']) !!}
        <label for="end_date">End date</label>
        @if($errors->has('end_date'))
            <label id="end_date-error" class="error" for="end_date">
                <strong>{!! $errors->first('end_date') !!}</strong>
            </label>
        @endif
    </div>

    <div class="input-field col s12">
        {!! Form::text('leader', null, ['class'=>'validate', 'placeholder' => '']) !!}
        <label for="leader">Leader</label>
        @if($errors->has('leader'))
            <label id="leader-error" class="error" for="leader">
                <strong>{!! $errors->first('leader') !!}</strong>
            </label>
        @endif
    </div>

    <div class="input-field col s12">
        {!! Form::text('mission', null, ['class' => 'validate', 'placeholder' => '']) !!}
        <label for="mission">Mission</label>
        @if($errors->has('mission'))
            <label id="mission-error" class="error" for="mission">
                <strong>{!! $errors->first('mission') !!}</strong>
            </label>
        @endif
    </div>

    <div class="input-field col s12">
        {!! Form::text('offer_to', null, ['class'=>'validate', 'placeholder' => '']) !!}
        <label for="location">Offer to</label>
        @if($errors->has('offer_to'))
            <label id="offer_to-error" class="error" for="offer_to">
                <strong>{!! $errors->first('offer_to') !!}</strong>
            </label>
        @endif
    </div>

    <div class="input-field col s12">
        <div class="actions clearfix">
            {!! Form::submit('Save', ['class'=>'waves-effect waves-blue btn-flat']) !!}
            <a href="{!! route('app.missions.index') !!}" class="waves-effect waves-blue btn-flat">Cancel</a>
        </div>
    </div>
</div>