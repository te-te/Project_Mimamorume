@extends('layouts.app')
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet" href="{{URL::to('/')}}/css/monitoring_app.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- 부가적인 테마 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<!-- 합쳐지고 최소화된 최신 자바스크립트 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>x
@section('content')
    <div class="body">
        <div>
            <a href="{{URL::to('/home')}}">Home</a> > <a href="{{URL::to('/monitoring')}}">모니터링</a> > <a href="{{URL::to('/chart')}}"><b>통계</b></a>
        </div>
        <div class="wrap">

        </div>
    </div>
@endsection