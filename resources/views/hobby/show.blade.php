@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Hobby Details
                        <div class="float-right"><a href="/user/{{$hobby->user->id}}">{{$hobby->user->name}}</a></div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <p>Name:<br><b>{{ $hobby->name }}</b></p>
                                <p>Beschreibung: <br><b>{{ $hobby->beschreibung }}</b></p>
                                @if($hobby->tags->count()>0)
                                    @can('update', $hobby)
                                    <p>
                                        <b>Verknüpfte Tags</b> (klicken, zum entfernen):
                                        <br>
                                        @foreach($hobby->tags as $tag)
                                            <a class="badge badge-{{$tag->style}}" href="/hobby/{{$hobby->id}}/tag/{{$tag->id}}/detach">{{$tag->name}}</a>
                                        @endforeach
                                    </p>
                                    @else
                                        <p>
                                            <b>Verknüpfte Tags</b>:<br>
                                            @foreach($hobby->tags as $tag)
                                                <a class="badge badge-{{$tag->style}}" href="/hobby/tag/{{$tag->id}}">{{$tag->name}}</a>
                                            @endforeach
                                        </p>
                                    @endcan
                                @endif
                                @can('update', $hobby)
                                <p>
                                    <b>Verfügbare Tags</b> (klicken, zum hinzufügen):
                                    <br>
                                    @foreach($verfuegbareTags as $tag)
                                        <a class="badge badge-{{$tag->style}}" href="/hobby/{{$hobby->id}}/tag/{{$tag->id}}/attach">{{$tag->name}}</a>
                                    @endforeach
                                </p>
                                @endcan
                            </div>
                            <div class="col-md-3">
                                @auth()
                                    @if(file_exists("img/hobby/". $hobby->id ."_gross.jpg"))
                                        <a href="/img/hobby/{{$hobby->id}}_gross.jpg" data-lightbox="{{$hobby->id}}_gross.jpg" data-title="{{ $hobby->name }}">
                                            <img class="img-fluid img-thumbnail" src="/img/hobby/{{$hobby->id}}_gross.jpg" alt="gross">
                                        </a>
                                    @endif
                                    <i class="fa fa-search-plus"></i> Bild anklicken zum Vergrößern
                                @endauth
                                @guest()
                                    @if(file_exists("img/hobby/". $hobby->id ."_verpixelt.jpg"))
                                            <img class="img-fluid" src="/img/hobby/{{$hobby->id}}_verpixelt.jpg" alt="verpixelt">
                                        </a>
                                    @endif
                                @endguest
                            </div>
                        </div>
                           <a class="float-right btn btn-success btn-sm mt-3" href="/hobby"><i class="fas fa-arrow-circle-up"></i> Zurück zur Übersicht</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
