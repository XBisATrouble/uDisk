<?php

namespace App\Http\Controllers;

use App\Repositories\FileRepositories;
use Auth;
use Illuminate\Support\Facades\Input;

class FilesController extends Controller
{
    private $file;

    /**
     * FilesController constructor.
     * @param $file
     */
    public function __construct(FileRepositories $file)
    {
        $this->file = $file; //依赖注入文件仓库
    }

    public function upload()
    {
        if($file = Input::file('file')) {
            //控制上传文件类型
            $allowed_extensions = ["doc", "ppt", "xls","docx","pptx"];
            if (!$file->getClientOriginalExtension() || !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
                return response()->json(['error' => '上传文件格式错误'],200);
            }

            //控制上传文件大小
            if ($file->getSize()>=10485760){
                return response()->json(['error' => '上传文件大小超过限制'],200);
            }

            $destinationPath = 'uploads/';
            $extension = $file->getClientOriginalExtension();
            $fileName = str_random(10).'.'.$extension;
            $file->move($destinationPath, $fileName);

            $anonymous='2';

            $attributes=[
                'path' => $destinationPath.$fileName,
                'user_id' => Auth::check()?Auth::user()->id:$anonymous,  //添加一个匿名用户anonymous作为未登录用户的账户
                'code' => str_random(6),
            ];
            $this->file->create($attributes);
            return response()->json([
                'success' => true,
                'code' => $attributes['code'],
                ],200);
        } else {
            return response()->json(['error' => '上传文件失败',],200);
        }
    }

    public function extract()
    {
        //因为复印店普遍使用低版本浏览器，因此采用最基本的 html 表格方式
        $code = Input::get('code');
        $file=$this->file->getFileByCode($code);
        if (!$file){
            return response()->json(['error' => '未找到相关结果']);
        }
        if (!$file->times){
            return response()->json(['error' => '该文件下载次数已超上限']);
        }
        if (!$this->file->decrease($file)){
            return response()->json(['error' => '下载失败']);
        }

        return response()->download(public_path($file->path));
    }
}
