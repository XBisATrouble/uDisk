<?php

namespace App\Http\Controllers;

use App\Repositories\FileRepositories;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class FilesController
 * @package App\Http\Controllers
 */
class FilesController extends Controller
{
    /**
     * @var FileRepositories
     */
    private $file;

    /**
     * FilesController constructor.
     * @param $file
     */
    public function __construct(FileRepositories $file)
    {
        $this->file = $file; //依赖注入文件仓库
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('files.extract');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        if($file = $request->file('file')) {
            //控制上传文件类型
            $allowed_extensions = ["doc", "ppt", "xls","xlsx","docx","pptx",'pdf'];
            if (!$file->getClientOriginalExtension() || !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
                return response()->json(['error' => '上传文件格式错误'],200);
            }

            //控制上传文件大小<=10m
            if ($file->getSize()>=10485760){
                return response()->json(['error' => '上传文件大小超过限制'],200);
            }

            $date = Carbon::now()->toDateString();

            $destinationPath = 'uploads/'.$date.'/';
            $extension = $file->getClientOriginalExtension();
            $originalFileName = $file->getClientOriginalName();
            $fileName = str_random(10).'.'.$extension;
            $file->move($destinationPath, $fileName);

            $anonymous = '2'; //默认用2号用户作为匿名用户
            $private = $request->get('private')?'T':'F';
            $times = Auth::check()?50:10;

            $attributes=[
                'path' => $destinationPath.$fileName,
                'user_id' => Auth::check()?Auth::user()->id:$anonymous,  //添加一个匿名用户anonymous作为未登录用户的账户
                'fileName' => $originalFileName,
                'private' => $private,
                'code' => str_random(6),
                'times' => $times,
                'ip' => request()->ip(),
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function extract(Request $request)
    {
        //因为复印店普遍使用低版本浏览器，因此采用最基本的 html 表格方式
        $code = $request->get('code');
        $file=$this->file->getFileByCode($code);

        if (!$file){
            return back()->with('error','未找到相关结果');
            //return response()->json(['error' => '未找到相关结果']);
        }

        if ($file->private=='T'){
            if ($file->user->stu_id != $request->get('stu_id')){
                return back()->with('error','该文件为私密文件，你没有权限下载');
                //return response()->json(['error' => '该文件为私密文件，你没有权限下载']);
            }
        }

        if (!$file->times){
            return back()->with('error','该文件下载次数已超上限');
            //return response()->json(['error' => '该文件下载次数已超上限']);
        }

        if (!$this->file->decrease($file)){
            return back()->with('error','下载失败');
            //return response()->json(['error' => '下载失败']);
        }

        return response()->download(public_path($file->path),$file->fileName);
    }
}
