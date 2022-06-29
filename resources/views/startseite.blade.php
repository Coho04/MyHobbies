@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Startseite') }}</div>
                    <div class="card-body">
                        Willkommen by Hobbys<br>
                        <a href="/impressum" class="btn btn-primary">Impressum</a>
                        <a href="/contact" class="btn btn-primary">Contact</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
