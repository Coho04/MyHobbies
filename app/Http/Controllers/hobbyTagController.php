<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Gate;

class hobbyTagController extends Controller
{
    public function getFilteredHobbies($tag_id)
    {
        $tag = new Tag();

        $filter = $tag::findOrFail($tag_id);

        $filteredHobbies = $filter->filteredHobbies()->paginate(10);
        return view('hobby.filteredByTag')->with(
            [
                'hobbies' => $filteredHobbies,
                'tag' => $filter
            ]
        );
    }

    public function attachTag($hobby_id, $tag_id) {
        $hobby = Hobby::findOrFail($hobby_id);

        if (Gate::denies('connect_hobbyTag', $hobby)) {
            abort(403, 'Das Hobby gehört dir nicht.');
        }

        $hobby->tags()->attach($tag_id);

        return back();
    }

    public function detachTag($hobby_id, $tag_id) {
        $hobby = Hobby::find($hobby_id);

        if (Gate::denies('connect_hobbyTag', $hobby)) {
            abort(403, 'Das Hobby gehört dir nicht.');
        }

        $hobby->tags()->detach($tag_id);
        return back();
    }
}
