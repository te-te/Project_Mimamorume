@extends('layouts.app')

<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="//code.jquery.com/jquery.min.js"></script>

<style>
  .list {
    display: inline-block;
    width: 200px;
    height: 70px;
    border-radius: 10px;
    border: 2px solid lightgray;
  }

  .list_link {
    float: left;
    margin-top: 10px;
    margin-left: 10px;
  }

  .thumbnale {
    float: left;
    width: 50px;
    height: 50px;
    border-radius: 50%;
  }

  p {
    padding: 5px;
    display: inline-block;
    color: gray;
  }
</style>

@section('content')
<br><br>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="panel-group">
            <a href="{{ url('userinfo') }}" class="btn btn-default" role="button">회원 정보</a>
            <a href="{{ url('addinfo') }}" class="btn btn-default" role="button">추가 정보</a>
            <a href="{{ url('matchinfo') }}" class="btn btn-default" role="button">계약 정보</a>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">대상자 정보</div>

            <div class="panel-body">
              @if ($target == '[]')
                대상이 없습니다. 대상을 추가하지 않으면 저희 서비스를 이용하실 수 없습니다. <br>
                추가 버튼을 눌러서 대상자 추가를 진행 해주시기 바랍니다. <br>
              @else

                @foreach($target as $t)
                  <div class="list">
                    <a class="list_link" href="{{ url('/addinfo/view', [$t->num]) }}">
                      <img class="thumbnale" src="{{URL::to('/')}}/images/profile/{{ $t->profile_image }}">
                      <p>{{ $t->name }} <br> {{ $t->cellphone }}</p>
                    </a>
                  </div>
                @endforeach
              @endif
              <div class="form-group">
                  <div class="col-md-6 col-md-offset-4">
                    <a href="{{ url('addinfo/create') }}" class="btn btn-primary" role="button">추가</a>
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
