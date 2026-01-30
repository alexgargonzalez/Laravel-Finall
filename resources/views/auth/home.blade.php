@extends('app.bootstrap.template')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in!
                    <hr>
                    Name: {{ Auth::user()->name }}<br>
                    Email: {{ Auth::user()->email }}<br>
                    Password:: {{ Auth::user()->password }}<br>
                    Created at: {{ Auth::user()->created_at->format('d/m/Y h:i:s') }}<br>
                    Edited at: {{ Auth::user()->updated_at->format('d/m/Y h:i:s') }}<br>
                    <a href="{{ route('home.edit') }}">Edit your profile.</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
