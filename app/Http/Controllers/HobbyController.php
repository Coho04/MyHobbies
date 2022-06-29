<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Gate;


class HobbyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(
            [
                'index', 'show'
            ]);
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $hobbies = Hobby::orderby('created_at')->paginate(10);
        return view('hobby.index')->with('hobbies', $hobbies);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('hobby.create');
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validated=  $request->validate(
            [
                'name' => 'required|min:3',
                'beschreibung' => 'required|min:5',
                'bild' => 'mimes: jpg,jpeg,bmp,png,gif'
            ]
        );
        $hobby = new Hobby(
            [
                'name' => $request['name'],
                'beschreibung' => $request['beschreibung'],
                'user_id' => auth()->id()
            ]
        );


        $hobby = Hobby::create($validated);
        $hobby->update($validated);
        $hobby->save();

        if ($request->bild) {
            $this->saveImages($request->bild, $hobby->id, 'hobby');
        }

        return redirect('/hobby/' . $hobby->id);
    }


    /**
     * @param \App\Models\Hobby $hobby
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Hobby $hobby)
    {

        $alleTags = Tag::all(); //Alle Tags holen
        $nutzeTags = $hobby->tags;
        $verTags = $alleTags->diff($nutzeTags);
        $meldg_success = Session::get('meldg_success');
        return view('hobby.show')->with(
            [
                'hobby' => $hobby,
                'meldg_success' => $meldg_success,
                'verfuegbareTags' => $verTags
            ]
        );
    }


    /**
     * @param \App\Models\Hobby $hobby
     * @return \Illuminate\Http\Response
     */
    public function edit(Hobby $hobby)
    {

        if (auth()->guest()) {
            abort(403);
        }

        abort_unless($hobby->user_id === auth()->id() || auth()->user()->rolle === 'admin', 403);

        return view('hobby.edit')->with('hobby', $hobby);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Hobby $hobby
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Hobby $hobby)
    {

        abort_unless(Gate::allows('update', $hobby), 403);

        $request->validate(
            [
                'name' => 'required|min:3',
                'beschreibung' => 'required|min:5',
                'bild' => 'mimes: jpg,jpeg,bmp,png,gif'
            ]
        );

        if ($request->bild) {
            $this->saveImages($request->bild, $hobby->id);
        }

        $hobby->update([
            'name' => $request->name,
            'beschreibung' => $request->beschreibung
        ]);
        return redirect('/home');
    }

    /**
     * @param \App\Models\Hobby $hobby
     * @return string
     */
    public function destroy(Hobby $hobby)
    {

        if (auth()->guest()) {
            abort(403);
        }

        abort_unless(Gate::allows('delete', $hobby), 403);

        $hobby->delete();
        return redirect()->back();
    }

    public static function saveImages($bildInput, $id)
    {
        $bild = Image::make($bildInput);
        $breite = $bild->width();
        $hohe = $bild->height();

        if ($breite > $hohe) {
            //QuerFormat
            Image::make($bildInput)->widen(1200)->save(public_path() . '/img/hobby/' . $id . '_gross.jpg');
            Image::make($bildInput)->widen(400)->save(public_path() . '/img/hobby/' . $id . '_verpixelt.jpg')->pixelate(12);
            Image::make($bildInput)->widen(60)->save(public_path() . '/img/hobby/' . $id . '_thumb.jpg');
        } else {
            //HochFormat
            Image::make($bildInput)->heighten(900)->save(public_path() . '/img/hobby/' . $id . '_gross.jpg');
            Image::make($bildInput)->heighten(400)->save(public_path() . '/img/hobby/' . $id . '_verpixelt.jpg')->pixelate(12);
            Image::make($bildInput)->heighten(60)->save(public_path() . '/img/hobby/' . $id . '_thumb.jpg');
        }
    }

    public function deleteImages($hobby_id)
    {
        if (file_exists(public_path() . '/img/hobby/' . $hobby_id . '_thumb.jpg')) {
            unlink(public_path() . '/img/hobby/' . $hobby_id . '_thumb.jpg');
        }
        if (file_exists(public_path() . '/img/hobby/' . $hobby_id . '_gross.jpg')) {
            unlink(public_path() . '/img/hobby/' . $hobby_id . '_gross.jpg');
        }
        if (file_exists(public_path() . '/img/hobby/' . $hobby_id . '_verpixelt.jpg')) {
            unlink(public_path() . '/img/hobby/' . $hobby_id . '_verpixelt.jpg');
        }
        return back();
    }
}
