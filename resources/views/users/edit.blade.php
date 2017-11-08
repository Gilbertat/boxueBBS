@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default col-md-10 col-md-offset-1">
            <div class="panel-heading">
                <h4>
                    <i class="glyphicon glyphicon-edit"></i>编辑个人资料
                </h4>
            </div>
            @include('common.error')
            <div class="panel-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST"
                      accept-charset="UTF-8"
                      enctype="multipart/form-data">

                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="name-field">用户名</label>
                        <input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $user->name) }}">
                    </div>

                    <div class="form-group">
                        <label for="email-filed">邮 箱</label>
                        <input class="form-control" type="text" name="email" id="email-filed" value="{{ old('email', $user->email) }}">
                    </div>

                    <div class="form-group">
                        <label for="introduction_field">个人简介</label>
                        <textarea class="form-control" name="introduction" id="introduction_field" rows="3">{{ old('introduction', $user->introduction) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="" class="avatar-label">用户头像</label>
                        <input type="file" name="avatar">

                        @if($user->avatar)
                            <br>
                            <img class="thumbnail img-responsive" src="{{ $user->avatar }}"  width="200" alt="用户头像">
                        @endif
                    </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection