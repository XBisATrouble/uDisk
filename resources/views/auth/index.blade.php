@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-info upload-file">
                    <div class="panel-body">
                        <table class="table">
                            <caption>我最近的文件</caption>
                            <thead>
                            <tr>
                                <th>名称</th>
                                <th>提取码</th>
                                <th>上传时间</th>
                                <th>是否为私密上传</th>
                                <th>剩余有效下载次数</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($files as $file)
                                <tr>
                                    <td>{{ $file->fileName }}</td>
                                    <td>{{ $file->code }}</td>
                                    <td>{{ $file->created_at }}</td>
                                    <td>{{ $file->private=='T'?'是':'否' }}</td>
                                    <td>{{ $file->times }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
