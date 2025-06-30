<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Espace;
use App\Models\Option;

class ImportController extends Controller
{
    public function showForm()
    {
        return view('import-espaces');
    }

    public function import(Request $request)
    {
        // Validation du fichier
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
            'type' => 'required|in:espaces,options' // Vérifier le type d'import
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file, 'r');

        if (!$handle) {
            return back()->withErrors(['csv_file' => 'Impossible d’ouvrir le fichier.']);
        }

        $header = fgetcsv($handle, 1000, ","); // Lire l'entête

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            if ($request->type === 'espaces') {
                // Vérifier que les colonnes existent
                if (!isset($data[0]) || !isset($data[1])) {
                    continue;
                }

                $nom = trim($data[0]);
                $prix_heure = (float) str_replace(',', '', trim($data[1]));

                // Vérifier si l'espace existe déjà
                $existingEspace = Espace::where('nom', $nom)->first();

                if (!$existingEspace) {
                    Espace::create([
                        'nom' => $nom,
                        'prix_heure' => $prix_heure
                    ]);
                }
            } elseif ($request->type === 'options') {
                // Vérifier que les colonnes existent
                if (!isset($data[0]) || !isset($data[1]) || !isset($data[2])) {
                    continue;
                }

                $code = trim($data[0]);
                $option = trim($data[1]);
                $prix = (float) str_replace(',', '', trim($data[2]));

                // Vérifier si l'option existe déjà
                $existingOption = Option::where('code', $code)->first();

                if (!$existingOption) {
                    Option::create([
                        'code' => $code,
                        'option' => $option,
                        'prix' => $prix
                    ]);
                }
            }
        }

        fclose($handle);

        return back()->with('success', 'Importation réussie.');
    }
}
