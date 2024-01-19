<!-- resources/views/admin/add-classes.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Ajouter des Classes</h2>

        <!-- Formulaire pour ajouter des classes -->
        <form action="{{ route('admin.storeClasses') }}" method="post">
            @csrf
            <!-- Ajoute les champs du formulaire pour ajouter des classes -->
            <div class="form-group">
                <label for="nom">Nom de la Classe:</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
@endsection
