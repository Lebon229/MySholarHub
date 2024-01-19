<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Eleve;
use App\Models\Note;



class StudentController extends Controller
{
    public function showResults(Request $request)
{
    // Validation des données du formulaire
    $validatedData = $request->validate([
        'matricule' => 'required|string|max:255',
    ]);

    // Récupère l'élève en fonction du matricule
    $student = Eleve::where('matricule', $validatedData['matricule'])->first();

    if (!$student) {
        // Redirige avec un message d'erreur si l'élève n'est pas trouvé
        return redirect()->back()->with('error', 'Aucun élève trouvé avec ce matricule.');
    }

    // Récupère les notes de l'élève
    $notes = $student->notes;

    //dd($notes);

    return view('student.results', compact('student', 'notes'));
}

}
