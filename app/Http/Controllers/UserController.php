<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use function PHPUnit\Framework\fileExists;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(User $user)
    {

        //$hobbies = hobby::select()->where('user_id',auth()->id())->orderBy('updated_at', 'DESC')->get();
        $hobbies = Hobby::select()->where('user_id', $user->id)->orderBy('updated_at', 'DESC')->get();
        return view('user.show')->with(
            [
                'user' => $user,
                'hobbies' => $hobbies
            ]
        );
    }

    /**
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        if (auth()->guest()) {
            abort(403);
        }

        abort_unless($user->id === auth()->id() || auth()->user()->rolle === 'admin', 403);

        return view('user.edit')->with(['user' => $user]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        abort_unless(Gate::allows('update', $user), 403);

        $request->validate(
            [
                'motto' => 'required|min:3',
                //'ueber_mich' => 'required|min:5',
                'bild' => 'mimes: jpg,jpeg,bmp,png,gif'
            ]
        );

        if ($request->bild) {
            $this->saveImages($request->bild, $user->id, 'hobby');
        }

        $user->update([
            'motto' => $request->motto,
            'ueber_mich' => $request->ueber_mich
        ]);
        return redirect('/user/' . $user->id);
    }

    /**
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function saveImages($bildInput)
    {
        $bild = Image::make($bildInput);
        $breite = $bild->width();
        $hohe = $bild->height();
        $id = auth()->id();

        if ($breite > $hohe) {
            // Querformat
            Image::make($bildInput)->widen(500)->save(public_path() . '/img/user/' . $id . '_gross.jpg');
            Image::make($bildInput)->widen(400)->pixelate(12)->save(public_path() . '/img/user/' . $id . '_verpixelt.jpg');
            Image::make($bildInput)->widen(60)->save(public_path() . '/img/user/' . $id . '_thumb.jpg');
        } else {
            // Hochformat
            Image::make($bildInput)->heighten(500)->save(public_path() . '/img/user/' . $id . '_gross.jpg');
            Image::make($bildInput)->heighten(400)->pixelate(12)->save(public_path() . '/img/user/' . $id . '_verpixelt.jpg');
            Image::make($bildInput)->heighten(60)->save(public_path() . '/img/user/' . $id . '_thumb.jpg');
        }
    }

    public function deleteImages()
    {
        $user_id = auth()->id();
        if (fileExists(public_path() . '/img/user/' . $user_id . '_thumb.jpg')) {
            unlink(public_path() . '/img/user/' . $user_id . '_thumb.jpg');
        } else if (public_path() . '/img/user/' . $user_id . '_gross.jpg') {
            unlink(public_path() . '/img/user/' . $user_id . '_gross.jpg');
        } else if (public_path() . '/img/user/' . $user_id . '_verpixelt.jpg') {
            unlink(public_path() . '/img/hobby/' . $user_id . '_verpixelt.jpg');
        }
        return back();
    }
}
