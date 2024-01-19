<!-- resources/views/admin/view-class.blade.php -->

@extends('layouts.app')

@section('content')

<div class="container">
        <!-- ... ton contenu ... -->

        <style>
            .table-bordered-thick th,
            .table-bordered-thick td {
                border: 2px solid black; /* Ou toute autre couleur de bordure de ton choix */
            }
        </style>
    </div>

    <div class="container">
            <center><h2><u>Classe de {{ $classe->nom }} </u></h2></center>
            <br>
        <!-- Formulaire pour ajouter des notes -->
        <!-- Code de la vue pour le formulaire d'ajout de notes -->
<!-- Code de la vue pour le formulaire d'ajout de notes -->





<!-- Code de la vue pour le formulaire d'ajout de notes -->
<form action="{{ route('admin.addNotes') }}" method="post">
    @csrf
    <input type="hidden" name="classe_id" value="{{ $classe->id }}">

    <table class="table table-bordered-thick table-hover">
        <thead>
            <tr>
                <th>Élèves</th>
                @foreach($matieres as $matiere)
                    <th>{{ $matiere->nom }} ({{ $matiere->coefficient }})</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($eleves as $eleve)
                <tr>
                    <td>{{ $eleve->nom }} {{ $eleve->prenoms }} </td>
                    @foreach($matieres as $matiere)
                        <td>
                            @php
                                // Récupère la note de l'élève dans la matière
                                $noteEleve = $eleve->notes->where('id_matiere', $matiere->id)->first();
                            @endphp

                            {{-- Affiche les champs de saisie pour les interrogations et devoirs --}}
                            <center><h10><font color="blue">***Interrogations***</font></h10></center>

                            <input type="number" name="notes[{{ $eleve->id }}][{{ $matiere->id }}][interro_1]" class="form-control interro" placeholder="Interro 1" value="{{ $noteEleve ? $noteEleve->interro_1 : '' }}" min="0" max="20">
                            <input type="number" name="notes[{{ $eleve->id }}][{{ $matiere->id }}][interro_2]" class="form-control interro" placeholder="Interro 2" value="{{ $noteEleve ? $noteEleve->interro_2 : '' }}" min="0" max="20">
                            <input type="number" name="notes[{{ $eleve->id }}][{{ $matiere->id }}][interro_3]" class="form-control interro" placeholder="Interro 3" value="{{ $noteEleve ? $noteEleve->interro_3 : '' }}" min="0" max="20">
                            <input type="number" name="notes[{{ $eleve->id }}][{{ $matiere->id }}][interro_4]" class="form-control interro" placeholder="Interro 4" value="{{ $noteEleve ? $noteEleve->interro_4 : '' }}" min="0" max="20">
                            <br>
                            <center><h10><font color="green">***Devoirs***</font></h10></center>
                            <input type="number" name="notes[{{ $eleve->id }}][{{ $matiere->id }}][devoir_1]" class="form-control devoir" placeholder="Devoir 1" value="{{ $noteEleve ? $noteEleve->devoir_1 : '' }}" min="0" max="20">
                            <input type="number" name="notes[{{ $eleve->id }}][{{ $matiere->id }}][devoir_2]" class="form-control devoir" placeholder="Devoir 2" value="{{ $noteEleve ? $noteEleve->devoir_2 : '' }}" min="0" max="20">


                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <button type="submit" class="btn btn-primary">Enregistrer les Notes</button>
</form>











    </div>
@endsection
