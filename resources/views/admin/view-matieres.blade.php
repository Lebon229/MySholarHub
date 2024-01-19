<!-- resources/views/admin/view-matieres.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Gérer les Matières</h2>

        <!-- Bouton pour afficher le formulaire d'ajout de matière -->
        <button class="btn btn-success" onclick="toggleMatiereForm()">Ajouter une Matière</button>

        <!-- Formulaire pour ajouter une matière (initialement caché) -->
        <div id="addMatiereForm" style="display: none; margin-top: 20px;">
            <form action="{{ route('admin.addMatiere') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="nom">Nom de la matière:</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="coefficient">Coefficient de la matière:</label>
                    <input type="number" name="coefficient" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="classe_id">Classe associée:</label>
                    <select name="classe_id" class="form-control" required>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}">{{ $classe->nom }} </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Ajouter la matière</button>
            </form>
        </div>
        <br>
        <br>

        <!-- Affiche la liste des matières -->
        <div>
            @foreach($matieres as $matiere)
            <p>{{ $matiere->nom }} - Coefficient {{ $matiere->coefficient }} - Classe {{ optional($matiere->classe)->nom }} </p>
            @endforeach
        </div>
    </div>

    <script>
        function toggleMatiereForm() {
            // Affiche ou cache le formulaire d'ajout de matière
            var form = document.getElementById("addMatiereForm");
            form.style.display = form.style.display === "none" ? "block" : "none";
        }
    </script>
@endsection
