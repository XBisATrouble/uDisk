<?php

namespace App\Http\Controllers;

use App\Repositories\FileRepositories;
use Auth;
use Illuminate\Http\Request;

/**
 * Class UsersController
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{
    /**
     * @var FileRepositories
     */
    private $files;

    /**
     * UsersController constructor.
     * @param $files
     */
    public function __construct(FileRepositories $files)
    {
        $this->files = $files;
        $this->middleware('auth');
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $files=$this->files->getFilesFeedByUser(Auth::user()->id);
        return view('auth.index',compact('files'));
    }
}
