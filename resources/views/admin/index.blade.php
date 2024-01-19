<!-- resources/views/admin/view-eleves.blade.php -->

@extends('layouts.app')

@section('content')
<div class="jumbotron text-center">
    <h1>Bienvenue sur MyScholarHub</h1>
    <p>La plateforme idéale pour la bonne gestion de vos aprenants.</p>

    <!-- Autres boutons -->
    <div class="mb-3">
        <form action="{{ route('admin.addClasses') }}" method="post" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-warning mr-2">Ajouter des Classes</button>
        </form>
        <a href="{{ route('admin.viewMatieres') }}" class="btn btn-primary mr-2">Ajouter des Matières</a>
        <button class="btn btn-success mr-2" onclick="toggleForm()">Ajouter un Élève</button>
        <a href="{{ route('admin.manageClasses') }}" class="btn btn-info">Gérer les Classes</a>
        <!-- Ajoute d'autres boutons au besoin -->
    </div>

    <!-- Formulaire pour ajouter un élève (initialement caché) -->
    <div id="addStudentForm" style="display: none; margin-top: 20px;">
        <form action="{{ route('admin.addStudent') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="nom">Nom de l'élève:</label>
                <input type="text" name="nom" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="prenoms">Prénoms de l'élève:</label>
                <input type="text" name="prenoms" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="matricule">Matricule de l'élève:</label>
                <input type="text" name="matricule" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="classe_id">Classe de l'élève:</label>
                <select name="classe_id" class="form-control" required>
                    @foreach($classes as $classe)
                        <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Ajouter l'élève</button>
        </form>
    </div>

    <script>
        function toggleForm() {
            // Affiche ou cache le formulaire d'ajout d'élève
            var form = document.getElementById("addStudentForm");
            form.style.display = form.style.display === "none" ? "block" : "none";
        }
    </script>
</div>
@endsection
