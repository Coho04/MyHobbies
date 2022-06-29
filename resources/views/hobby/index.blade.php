@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Alle Hobbies</div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($hobbies as $hobby)

                                <li class="list-group-item">

                                    @if(file_exists("img/hobby/". $hobby->id ."_thumb.jpg"))
                                        <a class="mr-1" title="Details anzeigen" href="/hobby/{{ $hobby->id }}"><img src="/img/hobby/{{$hobby->id}}_thumb.jpg" alt="thumb"></a>
                                    @endif

                                    {{$hobby->name}}

                                    <a class="float-right ml-2 btn btn-sm btn-outline-secondary" href="/hobby/{{$hobby->id}}"><i class="fas fa-book"></i> Details</a>

                                    <span class="mx-2">von <a
                                            href="/user/{{$hobby->user->id}}">{{$hobby->user->name}}</a>  ( {{$hobby->user->hobbies->count()}})
                                        @if(file_exists("img/user/". $hobby->user->id ."_thumb.jpg"))
                                            <a class="mr-1" title="Details anzeigen"
                                               href="/user/{{ $hobby->user->id }}"><img
                                                    src="/img/hobby/{{$hobby->user->id}}_thumb.jpg" alt="thumb"></a>
                                        @endif
                                    </span>

                                    @can('update', $hobby)
                                        <a class="float-right ml-2 btn btn-sm btn-outline-primary"
                                           href="/hobby/{{$hobby->id}}/edit"><i class="fas fa-edit"></i>Edit</a>

                                        @endcan
                                        @can('delete', $hobby)
                                        <form style="display: inline;" action="/hobby/{{$hobby->id}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input class="float-right btn btn-outline-danger btn-sm ml-2" type="submit"
                                                   value="Löschen">
                                        </form>
                                        @endcan

                                        <div class="float-right"> {{ $hobby->created_at->diffForHumans()}} </div>
                                    <br>

                                    @foreach($hobby->tags as $tag)
                                        <a class="badge badge-{{$tag->style}}"
                                           href="/hobby/tag/{{ $tag->id }}">{{$tag->name}}</a>
                                    @endforeach

                                </li>
                            @endforeach
                        </ul>
                        @auth
                            <a class="float-right btn btn-success btn-sm mt-3" href="/hobby/create"><i
                                    class="fas fa-plus-circle"></i> Neues Hobby anlegen</a>
                        @endauth
                        <div class="mt-3">
                            {{ $hobbies->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
