@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Hobby bearbeiten</div>
                    <div class="card-body">
                        <form autocomplete="off" action="/hobby/{{ $hobby->id }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text"
                                       class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}" id="name"
                                       name="name" value="{{ old('name') ?? $hobby->name}}">
                                <small class="form-text text-danger">{!! $errors->first('name') !!}</small>
                            </div>
                            <div class="mb-2">
                                @if(file_exists("img/hobby/". $hobby->id ."_gross.jpg"))
                                    <img style="max-width: 400px; max-height: 300px;" src="/img/hobby/{{$hobby->id}}_gross.jpg" alt="gross">
                                    <div class="float-right">
                                        <a class="btn btn-sm btn-outline-danger" href="/delete-image/hobby/{{$hobby->id}}">Bild löschen</a>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="name">Bild</label>
                                <input type="file"
                                       class="form-control {{ $errors->has('bild') ? 'border-danger' : '' }}"
                                       id="bild" name="bild" value="">
                                <small class="form-text text-danger">{!! $errors->first('bild') !!}</small>
                            </div>
                            <div class="form-group">
                                <label for="beschreibung">Beschreibung</label>
                                <textarea class="form-control {{ $errors->has('beschreibung') ? 'border-danger' : '' }}" id="beschreibung" name="beschreibung" rows="5">{{ old('beschreibung') ?? $hobby->beschreibung }}</textarea>
                                <small class="form-text text-danger">{!! $errors->first('beschreibung') !!}</small>
                            </div>
                            <input class="btn btn-primary mt-4" type="submit" value="absenden">

                        </form>
                        <a class="btn btn-primary btn-sm mt-3 float-right" href="/hobby"><i class="fas fa-arrow-circle-up"></i> Zurück</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
