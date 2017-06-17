@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info upload-file">
                    <div class="panel-body">
                        {!! Form::open(['url' => 'extract']) !!}
                        {!! Form::label('message', '请输入提取码:') !!}
                        {!! Form::text('code') !!}
                        {!! Form::submit('提取') !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
@endsection
