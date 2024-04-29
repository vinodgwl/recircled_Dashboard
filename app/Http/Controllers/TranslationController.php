<?php

namespace App\Http\Controllers;
use App\Models\Translation;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->query('lang', 'en');
        app()->setLocale($lang);
        // $translations = Translation::all();
        // return view('translations.index', compact('translations'));
         return view('admin.translations.index');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'language' => 'required',
            'file' => 'required|mimes:csv|max:2048',
        ]);

        $language = $request->language ? $request->language : 'en';
        $file = $request->file('file');

        // Check if the language exists in the translations table
        $existingTranslations = Translation::where('language', $language)->get();

        // Delete existing translations if the language exists
        if ($existingTranslations->isNotEmpty()) {
            Translation::where('language', $language)->delete();
        }

        // Process the CSV file
        $handle = fopen($file, 'r');
        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            // Save data to the database
            // $keys = str_replace(' ', '_', strtolower($row[0]));
            $keys = $row[0];
            $values = $row[1];

            Translation::create([
                'language' => $language,
                'key' => $keys,
                'value' => $values,
            ]);

            // Save column values to language files
            $this->saveToLanguageFile($keys, $values, $language);
        }
        fclose($handle);
        
        // Set success message after data is successfully stored
        return redirect()->back()->with('success', 'Translation saved successfully');
    }

    public function saveToLanguageFile($key, $value, $language)
    {
        $key = str_replace(' ', '_', strtolower($key));
        $languageCode = $language;
        $directory = resource_path('lang/' . $languageCode);
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }
        $filePath = resource_path('lang/' . $languageCode . '/message.php');
        if (!File::exists($filePath)) {
            File::put($filePath, "<?php\n\nreturn [\n    // Your translation messages here\n];\n");
        }
        $languageFile = resource_path('lang/' . $languageCode . '/message.php');
        $messages = require $languageFile;

        if (!is_array($messages)) {
            $messages = [];
        }

        if (array_key_exists($key, $messages)) {
            return;
        }

        $messages[$key] = $value;
        file_put_contents($languageFile, '<?php return ' . var_export($messages, true) . ';');
    }
    public function exportSampleCsv(Request $request){
        // echo 'fiii'; die();
        // Validate request data
        $request->validate([
            'language' => 'required|in:en,fr,es,nl', // Add more languages as needed
        ]);
        // Fetch sample data from the database based on the selected language
        $language = $request->input('language');
        $translations = Translation::where('language', $language)->get();
      
        // Check if translations were found
        if ($translations->isEmpty()) {
            // echo ''
            // Handle case where translations are not found
            return response()->json(['message' => 'No translations found for the selected language'], 404);
        }
        // if (!$translations) {
        //     // If no next record is found, return a response indicating no more records
        //     return response()->json(['message' => 'No Existing translation found Pease upload new.']);
        //     // return response()->json(['message' => 'No More boxes available'], 404);
        //  }
        // Generate CSV content
        // $csvContent = "Key,Value\n"; // CSV header
        $csvContent = "";
        foreach ($translations as $translation) {
            $csvContent .= "{$translation->key},{$translation->value}\n";
        }

       
            // Generate unique file name
        $fileName = 'sample_translations_' . $language . '.csv';

         
        // Store the CSV content in a temporary file
        // Storage::put('temp/' . $fileName, $csvContent);
        $filePath = storage_path('app/temp/' . $fileName);
        file_put_contents($filePath, $csvContent);
       // Generate download response
        return response()->download($filePath, $fileName, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ])->deleteFileAfterSend(true);
    }
}
