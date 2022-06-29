@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard<a class="float-right btn btn-sm btn-outline-primary" href="/user/{{auth()->user()->id}}"><i class="fas fa-id-badge"></i> Zum Profil</a></div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-9">

                                @auth()
                                    <h2>Hallo {{auth()->user()->name}}</h2>
                                @endauth
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{session('status')}}
                                    </div>
                                @endif

                                    <h5><U>Dein Motto:</U></h5>
                                <p>{{ auth()->user()->motto ?? '' }}</p>

                                    <h5><U>Deine "Über-Mich" - Beschreibung:</U></h5>
                                <p>{{ auth()->user()->ueber_mich ?? '' }}</p>

                                <p>
                                    <a href="/user/{{ auth()->user()->id }}/edit" class="btn btn-primary">Profil bearbeiten</a>
                                </p>
                            </div>
                            <div class="col-md-3">
                                @if(file_exists("img/user/" . auth()->id() . "_gross.jpg"))
                                    <img class="img img-thumbnail" src="/img/user/{{ auth()->id() }}_gross.jpg" alt="{{ auth()->user()->name }}">
                                @endif
                            </div>
                        </div>

                        @isset($hobbies)
                            <h5><U>Deine Hobbys:</U></h5>

                            @foreach($hobbies as $hobby)
                                <li class="list-group-item">{{$hobby->name}}

                                    @if(file_exists("img/hobby/". $hobby->id ."_thumb.jpg"))
                                        <a class="mr-1" title="Details anzeigen" href="/hobby/{{ $hobby->id }}"><img src="/img/hobby/{{$hobby->id}}_thumb.jpg" alt="thumb"></a>
                                    @endif

                                    <a class="float-right ml-2 btn btn-sm btn-secondary" href="/hobby/{{$hobby->id}}"><i class="fas fa-book"></i> Details</a>

                                    <a class="float-right ml-2 btn btn-sm btn-primary" href="/hobby/{{$hobby->id}}/edit"><i class="fas fa-edit"></i>Edit</a>

                                    <form style="display: inline;" action="/hobby/{{$hobby->id}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input class="float-right btn btn-danger btn-sm ml-2" type="submit" value="Löschen">
                                    </form>

                                    <div class="float-right">{{ $hobby->created_at->diffForHumans()}}</div>
                                    <br>

                                    @foreach($hobby->tags as $tag)
                                        <a class="badge badge-{{$tag->style}}"
                                           href="/hobby/tag/{{ $tag->id }}">{{$tag->name}}</a>
                                    @endforeach

                                </li>
                            @endforeach

                        @endisset

                        <a class="float-right btn btn-success btn-sm mt-3" href="/hobby/create"><i class="fas fa-plus-circle"></i> Neues Hobby</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
