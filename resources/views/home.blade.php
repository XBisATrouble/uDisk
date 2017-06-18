@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info upload-file">
                <div class="panel-body">
                    <div id="validation-errors"></div>
                    {!! Form::open( array('url' =>['/upload'], 'method' => 'post', 'id'=>'fileForm', 'files'=>true) ) !!}
                        <label for="file" class="control-label">文件上传</label>
                        <input id="file" name="file" type="file"  required="required">
                        <br/>
                        @if(Auth::check())
                            <div class="checkbox">
                                <label>
                                    <input id="private"  type="checkbox" name="private">是否私密上传
                                </label>
                            </div>
                        @else
                            <input id="private"  type="hidden" name="private" value="0">
                        @endif
                    {!!Form::close()!!}
                </div>
            </div>

            <div class="show-code" style="display: none;"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        //ajax 上传
        $(document).ready(function() {
            var options = {
                beforeSubmit:  showRequest,
                success:       showResponse,
                dataType: 'json'
            };
            $('#fileForm input[name=file]').on('change', function(){
                //$('#upload').html('正在上传...');
                $('#fileForm').ajaxForm(options).submit();
            });
        });
        function showRequest() {
            $('.show-code').hide()
            return true;
        }
        function showResponse(response) {
            if (response.success==true) {
                $('.upload-file').hide()
                $('.show-code').show()
                $(".show-code").append('<div class="alert alert-success">恭喜您上传成功，您的提取码是： <strong>'+ response.code +'</strong><div>');
            } else {
                $("#validation-errors").append('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"aria-hidden="true"> &times; </button><strong>'+ response.error +'</strong><div>');
            }
        }
    })
</script>
@endsection
