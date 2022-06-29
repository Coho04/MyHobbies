@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Nutzer Detailansicht
                        @auth()
                            @if($user->name == auth()->user()->name)
                                <a class="float-right ml-2 btn btn-sm btn-outline-primary"
                                   href="/user/{{$user->id}}/edit"><i class="fas fa-edit"></i> Profil bearbeiten</a>
                            @endif
                        @endauth
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <h3>{{$user->name}}</h3>
                                <h6><b>Motto:</b></h6>
                                <p>{{$user->motto}}</p>
                                <h6><b>Über Mich:</b></h6>
                                <p>{{$user->ueber_mich }}</p>
                                <h6><b>Hobbies:</b></h6>
                                @if($user->hobbies->count() > 0)
                                    <ul class="list-group">
                                        @foreach($user->hobbies as $hobby)
                                            <li class="list-group-item">

                                                @if(file_exists("img/hobby/". $hobby->id ."_thumb.jpg"))
                                                    <a class="mr-1 " title="Details anzeigen" href="/hobby/{{ $hobby->id }}"><img src="/img/hobby/{{$hobby->id}}_thumb.jpg" alt="thumb"></a>
                                                @endif

                                                {{ $hobby->name }}

                                                <a class="float-right ml-2 btn btn-sm btn-outline-secondary"
                                                   href="/hobby/{{$hobby->id}}"><i class="fas fa-book"></i> Details</a>


                                                @can('update', $hobby)
                                                    <a class="float-right ml-2 btn btn-sm btn-outline-primary"
                                                       href="/hobby/{{$hobby->id}}/edit"><i class="fas fa-edit"></i>Edit</a>
                                                @endcan
                                                @can('delete', $hobby)
                                                    <form style="display: inline;" action="/hobby/{{$hobby->id}}"
                                                          method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input class="float-right btn btn-outline-danger btn-sm ml-2" type="submit" value="Löschen">
                                                    </form>
                                                @endcan

                                                <div class="float-right">{{ $hobby->created_at->diffForHumans() }}</div>
                                                <br>
                                                @foreach($hobby->tags as $tag)
                                                    <a class="badge badge-{{$tag->style}}"
                                                       href="/hobby/tag/{{ $tag->id }}">{{ $tag->name }}</a>
                                                @endforeach
                                            </li>
                                        @endforeach
                                    </ul>
                                @else()
                                    <p>{{ $user->name }} hat noch keine Hobbies angelegt.</p>
                                @endif
                            </div>
                            <div class="col-md-3">
                                @if(file_exists("img/user/". $user->id ."_gross.jpg"))
                                    <a class="mr-1 " title="Details anzeigen">
                                        <img class="img-thumbnail" src="/img/user/{{$user->id}}_gross.jpg" alt="thumb"></a>
                                @endif
                            </div>
                        </div>
                        <a class="btn btn-success btn-sm mt-3" href="{{ URL::previous() }}"><i
                                class="fas fa-arrow-circle-up"></i> Zurück zur Übersicht</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
