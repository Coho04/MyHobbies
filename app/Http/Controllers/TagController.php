<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function __construct() {
        $this->middleware('auth')->except(['index']);
        $this->middleware('admin php')->except(['index']);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        return view('tags.index')->with('tags', $tags);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|min:3',
                'style' => 'required|min:5'
            ]
        );

        $tag = new Tag(
            [
                'name' => $request['name'],
                'style' => $request['style']
            ]
        );
        $tag->save();
        return $this->index()->with([
            'meldung_success' => 'Der Tag <b>' . $tag->name . '</b> wurde gesetzt!'
        ]);
    }

    /**
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return view('tags.show')->with('tag', $tag);
    }

    /**
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('tags.edit')->with('tag', $tag);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate(
            [
                'name' => 'required|min:3',
                'style' => 'required|min:5'
            ]
        );

        $tag->update([
            'name' => $request->name,
            'style' => $request->style
        ]);
        return $this->index()->with([
            'meldung_success' => 'Der Tag <b>' . $request->name . '</b> wurde bearbeitet!'
        ]);
    }

    /**
     * @param \App\Models\Tag $tag
     * @return string
     */
    public function destroy(Tag $tag)
    {
        $old_name = $tag->name;
        $tag->delete();
        return $this->index()->with(['meldung_success' => 'Der Tag <b>' . $old_name . '</b> wurde bearbeitet!']);
    }
}

