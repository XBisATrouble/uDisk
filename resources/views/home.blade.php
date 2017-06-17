@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-info upload-file">
                <div class="panel-body">
                    <div id="validation-errors"></div>
                    {!! Form::open( array('url' =>['/upload'], 'method' => 'post', 'id'=>'imgForm', 'files'=>true) ) !!}
                    <div class="form-group">
                        <label>文件上传</label>
                        <input id="thumb" name="file" type="file"  required="required">
                        <input id="imgID"  type="hidden" name="id" value="">
                    </div>
                    {!!Form::close()!!}
                </div>
            </div>

            <div class="panel panel-info show-code" style="display: none;"></div>
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
            $('#imgForm input[name=file]').on('change', function(){
                //$('#upload').html('正在上传...');
                $('#imgForm').ajaxForm(options).submit();
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
                $(".show-code").append('<div class="alert">恭喜您上传成功，您的提取码是： <strong>'+ response.code +'</strong><div>');
            } else {
                $("#validation-errors").append('<div class="alert alert-error"><strong>'+ response.error +'</strong><div>');
            }
        }
    })
</script>
@endsection
