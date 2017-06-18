<?php
/**
 * Created by PhpStorm.
 * User: xb
 * Date: 2017/6/17
 * Time: 下午3:40
 */

namespace App\Repositories;



use App\Models\File;

class FileRepositories
{
    public function create($attributes)
    {
        return File::create($attributes);
    }

    public function getFileByCode($code)
    {
        return File::recent()->where('code',$code)->first();
    }

    public function decrease($file)
    {
        $file->times-=1;
        $file->save();
        return true;
    }

    public function getFilesFeedByUser($id)
    {
        return File::recent()->where('user_id',$id)->latest()->get();
    }
}