<?php
require 'vendor/autoload.php';

use Google\Cloud\Translate\V3\Client\TranslationServiceClient;
use Google\Cloud\Translate\V3\TranslateTextRequest;

// Cloud Run injecteert automatisch de PORT om op te luisteren
$port = getenv('PORT') ?: '8080';

// Eenvoudige routing: verwerk alleen POST-verzoeken op /translate
$uri = $_SERVER['REQUEST_URI'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $uri === '/translate') {
    
    // Verkrijg JSON-input
    $input = json_decode(file_get_contents('php://input'), true);
    $text = $input['text'] ?? null;
    $targetLanguage = $input['target_language'] ?? 'en'; // Standaard naar Engels

    if (!$text) {
        http_response_code(400);
        echo json_encode(['error' => 'Geen tekst meegegeven in het "text" veld.']);
        exit;
    }

    // Verkrijg het Google Project ID (Cloud Run vult deze omgevingsvariabele automatisch in)
    $projectId = getenv('GOOGLE_CLOUD_PROJECT');
    if (!$projectId) {
        // Fallback als de variabele niet is ingesteld (bijv. lokaal testen)
        $projectId = 'servive-bahned'; 
    }

    try {
        // Instantieer de client
        $translationServiceClient = new TranslationServiceClient();

        // Bouw het verzoek op
        $request = (new TranslateTextRequest())
            ->setFormattedParent($translationServiceClient->locationName($projectId, 'global'))
            ->setContents([$text])
            ->setTargetLanguageCode($targetLanguage);

        // Voer de vertaling uit
        $response = $translationServiceClient->translateText($request);
        $translations = [];

        foreach ($response->getTranslations() as $translation) {
            $translations[] = $translation->getTranslatedText();
        }

        header('Content-Type: application/json');
        echo json_encode([
            'original' => $text,
            'translated' => $translations[0] ?? ''
        ]);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

// Standaard status check voor Cloud Run
if ($uri === '/') {
    echo "PHP Translation Service is running.";
    exit;
}

http_response_code(404);
echo "Niet gevonden.";
