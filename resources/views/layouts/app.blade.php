<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <!-- 부트스트랩 -->
    <!-- 합쳐지고 최소화된 최신 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <!-- 부가적인 테마 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <!-- 합쳐지고 최소화된 최신 자바스크립트 -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    <!-- DatePicker -->
    <script type="text/javascript" src="{{ asset('js/jquery.simple-dtpicker.js') }}"></script>
    <link type="text/css" href="{{ asset('css/jquery.simple-dtpicker.css') }}" rel="stylesheet" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','MIMAMORUME')</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nav_app.css') }}" rel="stylesheet">

    <script>
        $(function(){
            $('*[name=date]').change(function(){
                $('#dateLog').val($('*[name=date]').val());
            });


            $(".zeta-menu li").hover(function(){
                $('ul:first',this).show();
            }, function(){
                $('ul:first',this).hide();
            });
        });
        function showModal(num){
            $('#'+num).modal('show');
        };

        function matchYesConfirm(url){
            if(confirm("정말로 수락하겠습니까?")){
               //var log = $(num).val();
                location.href=url;
            }
        }

        function dest(url){
            location.href=url;
        }

        function matchNoConfirm(url){
            if(confirm("거절하시면 알림이 사라집니다. 정말로 거절하겠습니까?")){
                location.href=url;
            }
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="nav">
                <a class="logo pull-left" href="{{ url('/') }}">
                    <img src="{{ URL::to('/') }}/images/main_logo.png" width="80" height="30">
                </a>
                    @if (Session::get('id'))
                        <div class="zeta-wrap">
                            <ul class="zeta-menu center-block">
                                <li>
                                    <a href="{{ url('/match') }}"><b>Contract</b></a>
                                </li>
                                <li>
                                    <a href="{{ url('/monitoring') }}"><b>Monitoring</b></a>
                                    <ul>
                                        <li><a href="{{ url('/snapshot') }}">Snapshot</a></li>
                                        <li><a href="{{ url('/chart') }}">Chart</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ url('/task') }}"><b>Task</b></a>
                                    <ul>
                                        <li><a href="{{ url('/task') }}">Shift</a></li>
                                        <li><a href="{{ url('/logSpec') }}">LogSpec</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="notice pull-right">
                            <ul class="nav navbar-nav">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        {{ Session::get('id') }} <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ url('/userinfo') }}">내 정보</a>
                                            <a href="{{ route('login.destroy') }}">로그아웃</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav">
                                <li class="dropdown pull-right">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        <img src="{{ URL::to('/') }}/images/notice_list.png" width="15" height="20">
                                    </a>
                                    <ul class="dropdown-menu" role="menu" style="width: 400px; text-align: center;">
                                            <hr>
                                        @if($notice == '[]')
                                            <p>새로운 알림이 없습니다</p>
                                            <hr>
                                        @else
                                            <?php $i = 1; ?>
                                            @foreach($notice as $n)
                                                @if($n->notice_kind == '매칭')
                                                    <a onclick=showModal('modal{{$n->num}}') class="notice"><?php echo $i; ?> : {{$n->notice_title}}</a>
                                                    <a href="{{URL::to('/noticeDest',[$n->num])}}" class="close" style="margin: 0 5px;">X</a>
                                                    <hr>
                                                @elseif($n->notice_kind == '수정')
                                                    <a onclick=showModal('modal{{$n->num}}') class="notice"><?php echo $i; ?> : {{$n->notice_title}}</a>
                                                    <a href="{{URL::to('/noticeDest',[$n->num])}}" class="close" style="margin: 0 5px;">X</a>
                                                    <hr>
                                                @elseif($n->notice_kind == '수락')
                                                        <?php echo $i; ?> : {{$n->notice_title}}
                                                    <a href="{{URL::to('/noticeDest',[$n->num])}}" class="close" style="margin: 0 5px;">X</a>
                                                    <hr>
                                                @else
                                                        <?php echo $i; ?> : {{$n->notice_title}}
                                                    <a href="{{URL::to('/noticeDest',[$n->num])}}" class="close" style="margin: 0 5px;">x</a>
                                                    <hr>
                                                @endif
                                                    <?php $i++; ?>
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="pull-right links" style="margin: 8px 50px 0 0;">
                            <a href="{{ route('login.create') }}" class="btn btn-warning" role="button">Login</a>
                            <a href="{{ route('join.create') }}" class="btn btn-warning" role="button">Join</a>
                        </div>
                    @endif
            </div>
    </nav>
    <div class="container">
    </div>
    @if(Session::get('id'))
        @if($notice != '[]')
            @foreach($notice as $n)
                <script>
                    $(function(){
                        $(':radio[name=week_check{{$n->num}}]').on('change',function(){
                            var weekInput = '<select class="form-control" id="work_week_input{{$n->num}}" name="work_week_input{{$n->num}}" style="width: 97%; margin-left: 15px;">';
                            weekInput+='<option value="주1회">주 1회</option>';
                            weekInput+='<option value="주2회">주 2회</option>';
                            weekInput+='<option value="주3회">주 3회</option>';
                            weekInput+='<option value="주4회">주 4회</option>';
                            weekInput+='<option value="주5회">주 5회</option>';
                            weekInput+='<option value="주6회">주 6회</option>';
                            weekInput+='<option value="주7회">주 7회</option>';
                            weekInput+='</select>';

                            if($("input:radio[name='week_check{{$n->num}}']:checked").val() == 'yes'){
                                $('.week{{$n->num}}').append(weekInput);
                            }else{
                                $('#work_week_input{{$n->num}}').remove();
                            }
                        });
                        $(':radio[name=work_start{{$n->num}}]').on('change',function(){
                            if($("input:radio[name='work_start{{$n->num}}']:checked").val() == 'yes'){
                                var weekInput = '<input type="hidden" value="yes" id="week_check_start_input{{$n->num}}" name="week_check_start_input{{$n->num}}">';

                                $('#start{{$n->num}}').append(weekInput);
                                $('#start{{$n->num}}').css('display','');
                            }else{
                                $('#start{{$n->num}}').css('display','none');
                                $('#start{{$n->num}}').remove($('#week_check_start_input{{$n->num}}'));
                            }
                        });
                        $(':radio[name=work_end{{$n->num}}]').on('change',function(){
                            if($("input:radio[name='work_end{{$n->num}}']:checked").val() == 'yes'){
                                var weekInput = '<input type="hidden" value="yes" id="week_check_end_input{{$n->num}}" name="week_check_end_input{{$n->num}}">';

                                $('#start{{$n->num}}').append(weekInput);
                                $('#end{{$n->num}}').css('display','');
                            }else{
                                $('#end{{$n->num}}').css('display','none');
                                $('#end{{$n->num}}').remove($('#week_check_end_input{{$n->num}}'));
                            }
                        });
                        $(':radio[name=work_start_time{{$n->num}}]').on('change',function(){
                            var weekInput = '<select class="form-control" id="work_start_time_input{{$n->num}}" name="work_start_time_input{{$n->num}}" style="width: 97%; margin-left: 15px;">';
                            for(var i = 0; i <= 24; i++){
                                weekInput+="<option value='"+i+":00'>"+i+":00</option>";
                            }

                            if($("input:radio[name='work_start_time{{$n->num}}']:checked").val() == 'yes'){
                                $('.start_time{{$n->num}}').append(weekInput);
                            }else{
                                $('#work_start_time_input{{$n->num}}').remove();
                            }
                        });
                        $(':radio[name=work_end_time{{$n->num}}]').on('change',function(){
                            var weekInput = '<select class="form-control" id="work_end_time_input{{$n->num}}" name="work_end_time_input{{$n->num}}" style="width: 97%; margin-left: 15px;">';
                            for(var i = 0; i <= 24; i++){
                                weekInput+="<option value='"+i+":00'>"+i+":00</option>";
                            }
                            weekInput+='</select>';

                            if($("input:radio[name='work_end_time{{$n->num}}']:checked").val() == 'yes'){
                                $('.end_time{{$n->num}}').append(weekInput);
                            }else{
                                $('#work_end_time_input{{$n->num}}').remove();
                            }
                        });
                    });
                </script>
                <form class="form-horizontal" name="form-horizontal" role="form" method="get" action="{{URL::to('/matchmodify',[$n->num])}}">
                    <div id="modal{{$n->num}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">매칭 수락</h4>
                                </div>
                                <div class="modal-body">
                                    <b>※ 매칭신청을 요청한 사용자의 정보입니다.</b><br>
                                    <br><label>이름</label> {{$n->name}}
                                    <br><label>유형</label> {{$n->user_type}}
                                    <br><label>나이</label> {{$n->age}}
                                    <br><label>성별</label> {{$n->gender}}
                                    <br><label>연락처</label> {{$n->cellphone}}
                                    <br><label>연락처2</label> {{$n->telephone}}
                                    <br><br>
                                    <b>※상대가 제시한 조건입니다.</b><br>
                                    <br><div style="width: 50%; float: left;"><label>근무일</label> <input readonly name="work_week_day{{$n->num}}" value="{{$n->work_week}}"></div>
                                    <div class="week{{$n->num}}">
                                        <label for="week_check_yes">변경</label><input type="radio" name="week_check{{$n->num}}" id="week_check_yes{{$n->num}}" value="yes">
                                        <label for="week_check_no">변경안함</label><input type="radio" name="week_check{{$n->num}}" id="week_check_no{{$n->num}}" value="no" checked>
                                    </div>
                                    <br><div style="width: 50%; float: left;"><label>근무 시작 날짜</label> <input readonly name="work_start_day{{$n->num}}" value="{{$n->work_start}}"></div>
                                    <div>
                                        <label for="work_start_yes{{$n->num}}">변경</label><input type="radio" name="work_start{{$n->num}}" id="work_start_yes{{$n->num}}" value="yes">
                                        <label for="work_start_no{{$n->num}}">변경안함</label><input type="radio" name="work_start{{$n->num}}" id="work_start_no{{$n->num}}" value="no" checked>
                                    </div>
                                    <div id="start{{$n->num}}" style="display: none; width: 97%; margin-left: 15px;">
                                        <input class="form-control" type="text" name="start_work{{$n->num}}" value="">
                                        <script type="text/javascript">
                                            $(function(){
                                                $('*[name=start_work{{$n->num}}]').appendDtpicker({
                                                    "futureOnly": true
                                                });
                                            });
                                        </script>
                                    </div>
                                    <br><div style="width: 50%; float: left;"><label>근무 종료 날짜</label> <input readonly name="work_end_day{{$n->num}}" value="{{$n->work_end}}"></div>
                                    <div>
                                        <label for="work_end_yes{{$n->num}}">변경</label><input type="radio" name="work_end{{$n->num}}" id="work_end_yes{{$n->num}}" value="yes">
                                        <label for="work_end_no{{$n->num}}">변경안함</label><input type="radio" name="work_end{{$n->num}}" id="work_end_no{{$n->num}}" value="no" checked>
                                    </div>
                                    <div id="end{{$n->num}}" style="display: none; width: 97%; margin-left: 15px;">
                                        <input class="form-control" type="text" name="end_work{{$n->num}}" value="">
                                        <script type="text/javascript">
                                            $(function(){
                                                $('*[name=end_work{{$n->num}}]').appendDtpicker({
                                                    "futureOnly": true
                                                });
                                            });
                                        </script>
                                    </div>
                                    <br><div style="width: 50%; float: left;"><label>근무 시작 시간</label><input readonly name="start_time{{$n->num}}" value="{{$n->work_start_time}}"></div>
                                    <div class="start_time{{$n->num}}">
                                        <label for="work_start_time_yes{{$n->num}}">변경</label><input type="radio" name="work_start_time{{$n->num}}" id="work_start_time_yes{{$n->num}}" value="yes">
                                        <label for="work_start_time_no{{$n->num}}">변경안함</label><input type="radio" name="work_start_time{{$n->num}}" id="work_start_time_no{{$n->num}}" value="no" checked>
                                    </div>
                                    <br><div style="width: 50%; float: left;"><label>근무 종료 시간</label> <input readonly name="end_time{{$n->num}}" value="{{$n->work_end_time}}"></div>
                                    <div class="end_time{{$n->num}}">
                                        <label for="work_end_time_yes{{$n->num}}">변경</label><input type="radio" name="work_end_time{{$n->num}}" id="work_end_time_yes{{$n->num}}" value="yes">
                                        <label for="work_end_time_no{{$n->num}}">변경안함</label><input type="radio" name="work_end_time{{$n->num}}" id="work_end_time_no{{$n->num}}" value="no" checked>
                                    </div>
                                </div>
                                <div style="width: 97%; margin-left: 15px;"><label>상대가 남긴 말</label>{{$n->notice_content}}</div><br>
                                <label for="content{{$n->num}}"style="margin-left: 15px;">전하고 싶은 말</label>
                                <textarea class="form-control" id="content{{$n->num}}" name="content{{$n->num}}" rows="5" style="width: 97%; margin-left: 15px;"></textarea>
                                <div class="modal-footer">
                                    @if($n->notice_check != 'true')
                                        <button type="submit" class="btn btn-primary" name="btn" value="modify">조건 변경 요청</button>
                                        <button type="submit" class="btn btn-primary" name="btn" value="yes">수락</button>
                                        <a onclick="matchNoConfirm('{{URL::to('/matchNo',[$n->num])}}')" class="btn btn-danger">거절</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endforeach
        @endif
    @endif
    @yield('content')
</div>
{{--
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>--}}
</body>
</html>
