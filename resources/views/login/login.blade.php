@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">로그인</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                            <label for="id" class="col-md-4 control-label">아이디</label>

                            <div class="col-md-6">
                                <input id="id" type="id" class="form-control" name="id" value="{{ old('id') }}" required autofocus>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('pw') ? ' has-error' : '' }}">
                            <label for="pw" class="col-md-4 control-label">비밀번호</label>

                            <div class="col-md-6">
                                <input id="pw" type="password" class="form-control" name="pw" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}> 아이디 저장
                                    </label>
                                </div>
                            </div>
                        </div>
                        @if (session('alert'))
                            <script>
                                var msg = '{{Session::get('alert')}}';
                                var exist = '{{Session::has('alert')}}';
                                if(exist){
                                    alert(msg);
                                }
                            </script>
                        @endif
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    로그인
                                </button>
{{--
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    패스워드를 잊으셨습니까?
                                </a>--}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection