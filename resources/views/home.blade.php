@extends('layouts.layout')

@section('content')
    <div class="col s12">
        <div class="page-title">Form Elements</div>
    </div>
    <div class="col s12 m12 l12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Input fields</span><br>
                <div class="row">
                    <form class="col s12">
                        <div class="row">
                            <div class="input-field col s6">
                                <input placeholder="Placeholder" id="first_name" type="text" class="validate">
                                <label for="first_name">First Name</label>
                            </div>
                            <div class="input-field col s6">
                                <input id="last_name" type="text" class="validate">
                                <label for="last_name">Last Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input disabled value="I am not editable" id="disabled" type="text" class="validate">
                                <label for="disabled">Disabled</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="password" type="password" class="validate">
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="email" type="email" class="validate">
                                <label for="email">Email</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <span class="card-title">Custom Error or Success Messages</span><br>
                <div class="row">
                    <form class="col s12">
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="email2" type="email" class="validate">
                                <label for="email2" data-error="wrong" data-success="right">Email</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <span class="card-title">Radio Buttons</span><br>
                <div class="row">
                    <form class="col s12">
                        <p class="p-v-xs">
                            <input name="group1" type="radio" id="test1"/>
                            <label for="test1">Red</label>
                        </p>
                        <p class="p-v-xs">
                            <input name="group1" type="radio" id="test2"/>
                            <label for="test2">Yellow</label>
                        </p>
                        <p class="p-v-xs">
                            <input class="with-gap" name="group1" type="radio" id="test3"/>
                            <label for="test3">Green</label>
                        </p>
                        <p class="p-v-xs">
                            <input name="group1" type="radio" id="test4" disabled="disabled"/>
                            <label for="test4">Brown</label>
                        </p>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <span class="card-title">Checkboxes</span><br>
                <div class="row">
                    <form class="col s12" action="#">
                        <p class="p-v-xs">
                            <input type="checkbox" id="test5"/>
                            <label for="test5">Red</label>
                        </p>
                        <p class="p-v-xs">
                            <input type="checkbox" id="test6" checked="checked"/>
                            <label for="test6">Yellow</label>
                        </p>
                        <p class="p-v-xs">
                            <input type="checkbox" class="filled-in" id="filled-in-box-example" checked="checked"/>
                            <label for="filled-in-box-example">Filled in</label>
                        </p>
                        <p class="p-v-xs">
                            <input type="checkbox" id="test7" checked="checked" disabled="disabled"/>
                            <label for="test7">Green</label>
                        </p>
                        <p class="p-v-xs">
                            <input type="checkbox" id="test8" disabled="disabled"/>
                            <label for="test8">Brown</label>
                        </p>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <span class="card-title">Date Picker</span>
                <div class="row">
                    <div class="col s12">
                        <label for="birthdate">Birthdate</label>
                        <input id="birthdate" type="text" class="datepicker">
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <span class="card-title">Autocomplete</span>
                <div class="row">
                    <div class="col s12 m-b-xs">
                        <small>For example, type 'Goog'</small>
                    </div>
                    <div class="input-field col s12">
                        <i class="material-icons prefix">textsms</i>
                        <input type="text" id="autocomplete-input" class="autocomplete">
                        <label for="autocomplete-input">Autocomplete</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
