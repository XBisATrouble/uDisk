<?php

namespace App\Http\Controllers;

use App\Repositories\FileRepositories;
use Auth;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $files;

    /**
     * UsersController constructor.
     * @param $files
     */
    public function __construct(FileRepositories $files)
    {
        $this->files = $files;
    }


    public function index()
    {
        $files=$this->files->getFilesFeedByUser(Auth::user()->id);
        return view('auth.index',compact('files'));
    }
}
