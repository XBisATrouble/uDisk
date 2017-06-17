<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositories;
use Auth;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $user;

    /**
     * UsersController constructor.
     * @param $user
     */
    public function __construct(UserRepositories $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $user=$this->user->getUserFeed(Auth::user()->id);
        return view('user.index',compact('user'));
    }
}
