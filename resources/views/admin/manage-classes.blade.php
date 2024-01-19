<!-- resources/views/admin/manage-classes.blade.php -->

@extends('layouts.app')

@section('content')
    <center>
    <div class="container">
        <h2>Gérer les Classes</h2>

        <!-- Affiche la liste des classes sous forme de boutons -->
        <div class="btn-group-vertical">
            @foreach($classes as $classe)
                <a href="{{ route('admin.viewClass', ['id' => $classe->id]) }}" class="btn btn-primary">
                    {{ $classe->nom }}
                </a>
            @endforeach
        </div>
    </div>
    </center>
@endsection
