<?php
require 'vendor/autoload.php';

use Google\Cloud\Translate\V3\Client\TranslationServiceClient;
use Google\Cloud\Translate\V3\TranslateTextRequest;

// Cloud Run injecteert automatisch de PORT om op te luisteren
$port = getenv('PORT') ?: '8080';

// Eenvoudige routing: verwerk alleen POST-verzoeken op /translate
$uri = $_SERVER['REQUEST_URI'];



echo $uri;

?>

