<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe; // Assure-toi d'importer correctement le modèle Classe
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Note;

class AdminController extends Controller
{
    public function index()
    {
        $classes = Classe::all();

        // Passe les classes à la vue
        return view('admin.index', compact('classes'));
    }

    public function viewEleves()
    {
        // Logique pour afficher les élèves
    }


    public function viewNotes()
    {
        // Logique pour afficher les notes
    }

    public function viewClasses()
    {
        // Logique pour afficher les classes
    }

    public function addClasses()
    {
        // Logique pour ajouter des classes (affichage du formulaire, enregistrement en base de données, etc.)
        return view('admin.add-classes');
    }

    public function storeClasses(Request $request)
    {
        // Valide les données du formulaire
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $existingClass = Classe::where('nom', $request->nom)
            ->first();

        if ($existingClass) {
            // Redirige avec un message d'erreur
            return redirect()->route('admin.index')->with('error', 'Cette classe existe déjà.');}

        // Crée une nouvelle classe
        Classe::create([
            'nom' => $request->nom,
        ]);

        // Redirige avec un message de succès
        return redirect()->route('admin.index')->with('success', 'Classe ajoutée avec succès.');
        
    }

    public function classDetails(Request $request)
    {
        // Récupère les détails de la classe
        $classe = Classe::find($request->classe_id);

        // Récupère tous les élèves de la classe avec la relation de la classe
        $eleves = Eleve::where('classe_id', $request->classe_id)->with('classe')->get();

        // Récupère toutes les matières propres à la classe avec la relation de la classe
        $matieres = Matiere::where('classe_id', $request->classe_id)->with('classe')->get();

        // Récupère les notes de chaque élève dans chaque matière
        $notes = [];
        foreach ($eleves as $eleve) {
            foreach ($matieres as $matiere) {
                $note = Note::where('id_eleve', $eleve->id)
                            ->where('id_matiere', $matiere->id)
                            ->first();
                $notes[$eleve->id][$matiere->id] = $note ? $note->note : null;
            }
        }

        return view('admin.class-details', compact('classe', 'eleves', 'matieres', 'notes'));
    }

   

    public function saveStudentDetails(Request $request)
{
    // Récupère les données du formulaire
    $classeId = $request->classe_id;

    // Vérifie si la classe existe
    $classe = Classe::find($classeId);

    if (!$classe) {
        // Redirige avec un message d'erreur si la classe n'existe pas
        return redirect()->back()->with('error', 'La classe sélectionnée n\'existe pas.');
    }

    // Crée un nouvel élève avec la classe associée
    $eleve = Eleve::create([
        'nom' => $request->nom,
        'prenoms' => $request->prenoms,
        'matricule' => $request->matricule,
        'classe_id' => $classeId,
    ]);

    // Récupère toutes les matières propres à la classe
    $matieres = Matiere::where('classe_id', $classeId)->get();

    // Enregistre les notes de l'élève pour chaque matière
    foreach ($matieres as $matiere) {
        // Récupère la note depuis le tableau de notes
        $note = $request->input("notes.{$eleve->id}.{$matiere->id}");

        // Enregistre la note seulement si elle est présente
        if ($note !== null) {
            Note::create([
                'id_classe' => $classeId,
                'id_eleve' => $eleve->id,
                'id_matiere' => $matiere->id,
                'note' => $note,
            ]);
        }
    }

    // Redirige avec un message de succès
    return redirect()->back()->with('success', 'Détails de l\'élève ajoutés avec succès.');
}


    public function addStudent(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'matricule' => 'required|string|max:255',
            'classe_id' => 'required|exists:classes,id',
        ]);

        // Ajoute la colonne classe_id aux données validées
        $validatedData['classe_id'] = $request->classe_id;

        // Crée un nouvel élève
        Eleve::create($validatedData);

        // Redirige avec un message de succès
        return redirect()->back()->with('success', 'Élève ajouté avec succès.');
    }
    
    public function viewMatieres()
    {
        // Récupère la liste de toutes les matières
        $matieres = Matiere::all();

        // Récupère la liste de toutes les classes pour la liste déroulante
        $classes = Classe::all();

        return view('admin.view-matieres', compact('matieres', 'classes'));
    }

    public function addMatiere(Request $request)
{
    // Validation des données du formulaire
    $validatedData = $request->validate([
        'nom' => 'required|string|max:255',
        'coefficient' => 'required|numeric',
        'classe_id' => 'required|exists:classes,id',
    ]);

    // Crée une nouvelle matière
    $matiere = Matiere::create($validatedData);

    // Récupère la classe associée à la matière
    $classe = Classe::find($validatedData['classe_id']);

    // Ajoute la matière à la classe
    $classe->matieres()->attach($matiere->id);

    // Redirige avec un message de succès
    return redirect()->back()->with('success', 'Matière ajoutée avec succès à la classe.');
}

    public function viewClasse($classeId)
    {
        // Récupère la classe
        $classe = Classe::findOrFail($classeId);

        // Récupère la liste des élèves de la classe
        $eleves = Eleve::where('classe_id', $classeId)->get();

        // Récupère la liste des matières de la classe
        $matieres = Matiere::where('classe_id', $classeId)->get();

        // Pour chaque élève, récupère ses notes dans chaque matière
        $notesParEleve = [];
        foreach ($eleves as $eleve) {
            $notesParEleve[$eleve->id] = Note::where('eleve_id', $eleve->id)->get();
        }

        return view('admin.view-classe', compact('classe', 'eleves', 'matieres', 'notesParEleve'));
    }

    public function saveNotes(Request $request)
    {
        // Récupère les données du formulaire
        $notes = $request->input('notes');

        // Enregistre les notes dans la base de données
        foreach ($notes as $eleveId => $matieres) {
            foreach ($matieres as $matiereId => $note) {
                Note::updateOrCreate(
                    ['eleve_id' => $eleveId, 'matiere_id' => $matiereId],
                    ['note' => $note]
                );
            }
        }

        // Redirige avec un message de succès
        return redirect()->back()->with('success', 'Notes enregistrées avec succès.');
    }

    public function manageClasses()
    {
        // Récupère la liste de toutes les classes
        $classes = Classe::all();

        return view('admin.manage-classes', compact('classes'));
    }

    public function viewClass($id)
{
    // Récupère la classe spécifiée par son ID
    $classe = Classe::findOrFail($id);

    // Charge explicitement la relation avec les matières
    $classe->load('matieres');

    // Ajoute ces lignes pour déboguer
    //dd($classe);
   // dd($classe->matieres);

    // Charge la liste des élèves associés à cette classe
    $eleves = $classe->eleves ?? [];
    $matieres = $classe->matieres ?? [];

    return view('admin.view-class', compact('classe', 'eleves', 'matieres'));
}

public function addNotes(Request $request)
{
    // Validation des données du formulaire
    $validatedData = $request->validate([
        'classe_id' => 'required|exists:classes,id',
        'notes.*.*.*' => 'nullable|numeric', // On permet des valeurs nulles pour les cases non remplies
    ]);

    // Récupère la classe
    $classe = Classe::findOrFail($validatedData['classe_id']);

    // Enregistre les notes pour chaque élève et chaque matière
    foreach ($validatedData['notes'] as $eleveId => $matieres) {
        $eleve = $classe->eleves->find($eleveId);
        
        if ($eleve) {
            foreach ($matieres as $matiereId => $notes) {
                // Récupère la note de l'élève dans la matière
                $noteEleve = $eleve->notes->where('id_matiere', $matiereId)->first();

                if ($noteEleve) {
                    // Si l'élève a déjà une note, met à jour la note existante
                    $noteEleve->update([
                        'interro_1' => $notes['interro_1'],
                        'interro_2' => $notes['interro_2'],
                        'interro_3' => $notes['interro_3'],
                        'interro_4' => $notes['interro_4'],
                        'devoir_1' => $notes['devoir_1'],
                        'devoir_2' => $notes['devoir_2'],
                    ]);
                } else {
                    // Sinon, crée une nouvelle note dans la base de données
                    Note::create([
                        'classe_id' => $classe->id,
                        'id_eleve' => $eleveId,
                        'id_matiere' => $matiereId,
                        'interro_1' => $notes['interro_1'],
                        'interro_2' => $notes['interro_2'],
                        'interro_3' => $notes['interro_3'],
                        'interro_4' => $notes['interro_4'],
                        'devoir_1' => $notes['devoir_1'],
                        'devoir_2' => $notes['devoir_2'],
                    ]);
                }
            }
        }
    }

    return redirect()->back()->with('success', 'Notes enregistrées avec succès.');
}


    // ...


    // Ajoute d'autres méthodes au besoin
}