<!-- resources/views/welcome.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1>Bienvenue sur MyScholarHub</h1>
        <p>La plateforme pour suivre les résultats scolaires de vos enfants.</p>
        <form action="{{ route('student.showResults') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="matricule">Matricule de l'élève:</label>
        <input type="text" name="matricule" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Consulter les résultats</button>
</form>
    </div>
@endsection
