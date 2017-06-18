@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        下载文件
                    </div>
                    <div class="panel-body">
                        @if(session('error')!=null)
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">
                                    &times;
                                </button>
                                {{ session('error') }}
                            </div>
                        @endif
                        <form action="/extract" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="code" class="control-label">提取码</label>
                                <input id="code" name="code" type="text" class="form-control" placeholder="请输入提取码" value="{{ old('code') }}">
                            </div>
                            <div class="form-group">
                                <label for="stu_id" class="control-label">学号 (若不是私密上传则不用填写)</label>
                                <input id="stu_id" name="stu_id" type="text" class="form-control" placeholder="请输入学号">
                            </div>
                            <button class="btn btn-primary">提取</button>
                        </form>
                    </div>
                </div>
            </div>
      </div>
    </div>
@endsection
