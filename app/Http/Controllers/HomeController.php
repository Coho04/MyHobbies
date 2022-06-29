<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Hobby;

class HomeController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $hobbies = Hobby::select()->where('user_id',auth()->id())->orderBy('updated_at', 'DESC')->get();
        return view('home')->with([
            'hobbies'=>$hobbies
        ]);
    }
}
