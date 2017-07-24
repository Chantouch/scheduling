<div class="row">
    <div class="input-field col s6{!! $errors->has('name') ? ' invalid' : '' !!}">
        {!! Form::text('start_date', isset($mission) ? $mission->start_date->format('d-m-Y') : null, ['class'=> 'validate datepicker','placeholder' => 'ថ្ងៃខែឆ្នាំ']) !!}
        <label for="start_date">ថ្ងៃចាប់ផ្តើម</label>
        @if($errors->has('start_date'))
            <label id="start_date-error" class="error" for="start_date">
                <strong>{!! $errors->first('start_date') !!}</strong>
            </label>
        @endif
    </div>

    <div class="input-field col s6">
        {!! Form::text('end_date', isset($mission) ? $mission->end_date->format('d-m-Y') : null, ['class' => 'validate datepicker', 'placeholder' => 'ថ្ងៃខែឆ្នាំ']) !!}
        <label for="end_date">ថ្ងៃបញ្ចប់</label>
        @if($errors->has('end_date'))
            <label id="end_date-error" class="error" for="end_date">
                <strong>{!! $errors->first('end_date') !!}</strong>
            </label>
        @endif
    </div>

    <div class="input-field col s12">
        {!! Form::text('leader', null, ['class'=>'validate', 'placeholder' => '']) !!}
        <label for="leader">ថ្នាក់ដឹកនាំ</label>
        @if($errors->has('leader'))
            <label id="leader-error" class="error" for="leader">
                <strong>{!! $errors->first('leader') !!}</strong>
            </label>
        @endif
    </div>

    <div class="input-field col s12">
        {!! Form::text('mission', null, ['class' => 'validate', 'placeholder' => '']) !!}
        <label for="mission">បេសកកម្ម</label>
        @if($errors->has('mission'))
            <label id="mission-error" class="error" for="mission">
                <strong>{!! $errors->first('mission') !!}</strong>
            </label>
        @endif
    </div>

    <div class="input-field col s12">
        {!! Form::text('offer_to', null, ['class'=>'validate', 'placeholder' => '']) !!}
        <label for="location">ផ្ទេរសិទ្ធ</label>
        @if($errors->has('offer_to'))
            <label id="offer_to-error" class="error" for="offer_to">
                <strong>{!! $errors->first('offer_to') !!}</strong>
            </label>
        @endif
    </div>

    <div class="input-field col s12">
        <div class="actions clearfix">
            {{--{!! Form::submit('រក្សាទុក', ['class'=>'waves-effect waves-blue btn green']) !!}--}}
            <button type="submit" class="waves-effect waves-blue btn blue">រក្សាទុក</button>
            <a href="{!! route('app.missions.index') !!}" class="waves-effect waves-blue btn red">បោះបង់</a>
        </div>
    </div>
</div>