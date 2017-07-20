<div class="side-nav-wrapper">
    <div class="sidebar-profile">
        <div class="sidebar-profile-image">
            <img src="{!! asset('assets/images/profile-image.png') !!}" class="circle" alt="">
        </div>
        <div class="sidebar-profile-info">
            @if(Auth::check())
                <a href="javascript:void(0);" class="account-settings-link">
                    <p>{!! Auth::user()->name !!}</p>
                    <span>{!! Auth::user()->email !!}<i class="material-icons right">arrow_drop_down</i></span>
                </a>
            @endif
        </div>
    </div>
    <div class="sidebar-account-settings">
        <ul>
            <li class="no-padding">
                <a class="waves-effect waves-grey"><i class="material-icons">mail_outline</i>Inbox</a>
            </li>
            <li class="no-padding">
                <a class="waves-effect waves-grey"><i class="material-icons">star_border</i>Starred<span
                            class="new badge">18</span></a>
            </li>
            <li class="no-padding">
                <a class="waves-effect waves-grey"><i class="material-icons">done</i>Sent Mail</a>
            </li>
            <li class="no-padding">
                <a class="waves-effect waves-grey"><i class="material-icons">history</i>History<span
                            class="new grey lighten-1 badge">3 new</span></a>
            </li>
            <li class="divider"></li>
            <li class="no-padding">
                <a href="{!! url('/logout') !!}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                   class="waves-effect waves-grey">
                    <i class="material-icons">exit_to_app</i>
                    ចាកចេញ
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                      class="hidden">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>
    <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
        <li class="no-padding">
            <a class="waves-effect waves-grey" href="{!! route('home') !!}">
                <i class="material-icons">settings_input_svideo</i>ទំព័រដើម
            </a>
            <a href="{!! route('app.meetings.index') !!}"
               class="{{ Request::is('app/meetings*') ? 'active-page' : '' }}">
                <i class="material-icons">assessment</i> កិច្ចប្រជុំ
            </a>

            <a href="{!! route('app.missions.index') !!}"
               class="{{ Request::is('app/missions*') ? 'active-page' : '' }}">
                <i class="material-icons">assignment</i> បេសកកម្ម
            </a>
        </li>
    </ul>
    <div class="footer">
        <p class="copyright">Chantouch SEK ©</p>
        <a href="#!">Privacy</a> &amp; <a href="#!">Terms</a>
    </div>
</div>