@extends('layouts.layout')

@section('content')
    <div class="middle-content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l4">
                <div class="card stats-card">
                    <div class="card-content">
                        <div class="card-options">
                            <ul>
                                <li class="red-text"><span class="badge cyan lighten-1">gross</span></li>
                            </ul>
                        </div>
                        <span class="card-title">កិច្ចប្រជុំ</span>
                        <span class="stats-counter">មាន <span class="counter">{!! $this_week_meetings !!}</span><small>នៅសប្តាហ៏នេះ</small></span>
                    </div>
                    <div id="sparkline-bar"></div>
                </div>
            </div>
            <div class="col s12 m12 l4">
                <div class="card stats-card">
                    <div class="card-content">
                        <div class="card-options">
                            <ul>
                                <li><a href="javascript:void(0)"><i class="material-icons">more_vert</i></a></li>
                            </ul>
                        </div>
                        <span class="card-title">កិច្ចប្រជុំ</span>
                        <span class="stats-counter">មាន <span class="counter">{!! $this_month_meetings !!}</span><small>នៅក្នុងខែនេះ</small></span>
                    </div>
                    <div id="sparkline-line"></div>
                </div>
            </div>
            <div class="col s12 m12 l4">
                <div class="card stats-card">
                    <div class="card-content">
                        <span class="card-title">របាយការណ៏ប្រជុំ</span>
                        <span class="stats-counter"><span class="counter">{!! $last_week_meetings !!}</span><small>នៅសប្តាហ៏ មុន</small></span>
                        <div class="percent-info green-text">8% <i class="material-icons">trending_up</i></div>
                    </div>
                    <div class="progress stats-card-progress">
                        <div class="determinate" style="width: 70%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l4">
                <div class="card stats-card">
                    <div class="card-content">
                        <div class="card-options">
                            <ul>
                                <li class="red-text"><span class="badge cyan lighten-1">gross</span></li>
                            </ul>
                        </div>
                        <span class="card-title">បេសកកម្ម</span>
                        <span class="stats-counter">មាន <span class="counter">{!! $this_week_missions !!}</span><small>នៅសប្តាហ៏នេះ</small></span>
                    </div>
                    <div id="sparkline-bar"></div>
                </div>
            </div>
            <div class="col s12 m12 l4">
                <div class="card stats-card">
                    <div class="card-content">
                        <div class="card-options">
                            <ul>
                                <li><a href="javascript:void(0)"><i class="material-icons">more_vert</i></a></li>
                            </ul>
                        </div>
                        <span class="card-title">បេសកកម្ម</span>
                        <span class="stats-counter">មាន <span class="counter">{!! $this_month_missions !!}</span><small>នៅក្នុងខែនេះ</small></span>
                    </div>
                    <div id="sparkline-line"></div>
                </div>
            </div>
            <div class="col s12 m12 l4">
                <div class="card stats-card">
                    <div class="card-content">
                        <span class="card-title">របាយការណ៏បេសកកម្ម</span>
                        <span class="stats-counter"><span class="counter">{!! $last_week_missions !!}</span><small>នៅសប្តាហ៏ មុន</small></span>
                        <div class="percent-info green-text">8% <i class="material-icons">trending_up</i></div>
                    </div>
                    <div class="progress stats-card-progress">
                        <div class="determinate" style="width: 70%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l8">
                <div class="card visitors-card">
                    <div class="card-content">
                        <div class="card-options">
                            <ul>
                                <li><a href="javascript:void(0)" class="card-refresh">
                                        <i class="material-icons">refresh</i></a></li>
                            </ul>
                        </div>
                        <span class="card-title">Visitors<span
                                    class="secondary-title">Showing stats from the last week</span></span>
                        <div id="flotchart1"></div>
                    </div>
                </div>
            </div>
            <div class="col s12 m12 l4">
                <div class="card server-card">
                    <div class="card-content">
                        <div class="card-options">
                            <ul>
                                <li class="red-text"><span class="badge blue-grey lighten-3">optimal</span></li>
                            </ul>
                        </div>
                        <span class="card-title">Server Load</span>
                        <div class="server-load row">
                            <div class="server-stat col s4">
                                <p>167GB</p>
                                <span>Usage</span>
                            </div>
                            <div class="server-stat col s4">
                                <p>320GB</p>
                                <span>Space</span>
                            </div>
                            <div class="server-stat col s4">
                                <p>57.4%</p>
                                <span>CPU</span>
                            </div>
                        </div>
                        <div class="stats-info">
                            <ul>
                                <li>Google Chrome
                                    <div class="percent-info green-text right">32% <i
                                                class="material-icons">trending_up</i></div>
                                </li>
                                <li>Safari
                                    <div class="percent-info red-text right">20% <i
                                                class="material-icons">trending_down</i></div>
                                </li>
                                <li>Mozilla Firefox
                                    <div class="percent-info green-text right">18% <i
                                                class="material-icons">trending_up</i></div>
                                </li>
                            </ul>
                        </div>
                        <div id="flotchart2"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="card invoices-card">
                    <div class="card-content">
                        <div class="card-options">
                            <input type="text" class="expand-search" placeholder="Search" autocomplete="off">
                        </div>
                        <span class="card-title">Meetings Status</span>
                        <table class="responsive-table bordered">
                            <thead>
                            <tr>
                                <th>ល.រ</th>
                                <th class="size">កាលបរិច្ឆេទ</th>
                                <th class="size">ម៉ោង</th>
                                <th class="size">កម្មវត្ថុ</th>
                                <th class="size">មន្រ្តីអម/អង្គភាពពាក់ព័ន្ធ</th>
                                <th class="size">ទីកន្លែង</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($meetings))
                                @foreach($meetings as $i => $meeting)
                                    <tr id="{!! $meeting->hashid !!}">
                                        <td>{!! $i+1 !!}</td>
                                        <td>{!! $meeting->meeting_date !!}</td>
                                        <td>{!! $meeting->start_time.' - '.$meeting->end_time !!}</td>
                                        <td>{!! $meeting->subject !!}</td>
                                        <td>{!! $meeting->related_org !!}</td>
                                        <td>{!! $meeting->location !!}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="inner-sidebar">
        <span class="inner-sidebar-title">New Messages</span>
        <div class="message-list">
            <div class="info-item message-item"><img class="circle" src="assets/images/profile-image-2.png" alt="">
                <div class="message-info">
                    <div class="message-author">Ned Flanders</div>
                    <small>3 hours ago</small>
                </div>
            </div>
            <div class="info-item message-item"><img class="circle" src="assets/images/profile-image.png" alt="">
                <div class="message-info">
                    <div class="message-author">Peter Griffin</div>
                    <small>4 hours ago</small>
                </div>
            </div>
            <div class="info-item message-item"><img class="circle" src="assets/images/profile-image-1.png" alt="">
                <div class="message-info">
                    <div class="message-author">Lisa Simpson</div>
                    <small>2 days ago</small>
                </div>
            </div>
        </div>
        <span class="inner-sidebar-title">Events</span>
        <span class="info-item">Envato meeting<span class="new badge">12</span></span>
        <div class="inner-sidebar-divider"></div>
        <span class="info-item">Google I/O</span>
        <div class="inner-sidebar-divider"></div>
        <span class="info-item disabled">No more events scheduled</span>
        <div class="inner-sidebar-divider"></div>

        <span class="inner-sidebar-title">Stats <i class="material-icons">trending_up</i></span>
        <div class="sidebar-radar-chart">
            <canvas id="radar-chart" width="170" height="140"></canvas>
        </div>
    </div>
@endsection
@section('plugins')
    <script src="{!! asset('assets/plugins/waypoints/jquery.waypoints.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/counter-up-master/jquery.counterup.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/chart.js/chart.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/flot/jquery.flot.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/flot/jquery.flot.time.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/flot/jquery.flot.symbol.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/flot/jquery.flot.resize.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/flot/jquery.flot.tooltip.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/curvedlines/curvedLines.js') !!}"></script>
    <script src="{!! asset('assets/plugins/peity/jquery.peity.min.js') !!}"></script>
@stop
@section('script')
    <script src="{!! asset('assets/js/pages/dashboard.js') !!}"></script>
@stop