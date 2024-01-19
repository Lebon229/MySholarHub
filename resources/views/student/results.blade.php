<!-- resources/views/student/results.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4"><u>Résultats de l'élève {{ $student->nom }} {{ $student->prenoms }}</u></h2>

        @if ($notes->isEmpty())
            <div class="alert alert-info">
                Aucune note enregistrée pour cet élève.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Matières</th>
                            <th>1ère interrogation</th>
                            <th>2ème interrogation</th>
                            <th>3ème interrogation</th>
                            <th>4ème interrogation</th>
                            <th>1er Devoir</th>
                            <th>2ème Devoir</th>
                            <th>Moyenne</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notes as $note)
                            <tr>
                                <td>{{ $note->matiere->nom.' ('.$note->matiere->coefficient.') ' }}</td>
                                <td>{{ $note->interro_1 ?? 'N/A' }}</td>
                                <td>{{ $note->interro_2 ?? 'N/A' }}</td>
                                <td>{{ $note->interro_3 ?? 'N/A' }}</td>
                                <td>{{ $note->interro_4 ?? 'N/A' }}</td>
                                <td>{{ $note->devoir_1 ?? 'N/A' }}</td>
                                <td>{{ $note->devoir_2 ?? 'N/A' }}</td>
                                @php
                                $interroCount = count(array_filter([$note->interro_1, $note->interro_2, $note->interro_3, $note->interro_4], function ($item) {
                                    return $item !== null;
                                }));

                                $devoirCount = count(array_filter([$note->devoir_1, $note->devoir_2], function ($item) {
                                    return $item !== null;
                                }));

                                $moyenne = 0;

                                if ($interroCount > 0) {
                                    $moyenne += array_sum(array_filter([$note->interro_1, $note->interro_2, $note->interro_3, $note->interro_4])) / $interroCount;
                                }

                                if ($devoirCount > 0) {
                                    $moyenne += array_sum(array_filter([$note->devoir_1, $note->devoir_2])) / 1;
                                }

                                // Vérifie si le dénominateur est zéro avant de faire la division
                                $moyenne = $interroCount + $devoirCount > 0 ? round($moyenne / ($devoirCount+1), 2) : 'N/A';
                            @endphp
                                <td class="text-center" style="color: @if($moyenne >= 16) green @elseif($moyenne >= 14) #87CEEB @elseif($moyenne >= 12) orange @elseif($moyenne >= 10) #8B4513 @else red @endif;">
                                    {{ $moyenne }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
