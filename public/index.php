<?php
// Indonesian -> Dutch translator for Google Cloud Run.
// Uses the Cloud Translation API (v2 REST) authenticated with the
// Cloud Run service account via the metadata server (no key files needed).

const SOURCE_LANG = 'id';
const TARGET_LANG = 'nl';
const MAX_CHARS   = 2000;

/** Get an OAuth access token for the Cloud Run service account. */
function get_access_token(): string
{
    // Optional override for local testing: export GCP_ACCESS_TOKEN=$(gcloud auth print-access-token)
    $local = getenv('GCP_ACCESS_TOKEN');
    if ($local) {
        return $local;
    }

    $ch = curl_init('http://metadata.google.internal/computeMetadata/v1/instance/service-accounts/default/token');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => ['Metadata-Flavor: Google'],
        CURLOPT_TIMEOUT        => 5,
    ]);
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($body === false || $code !== 200) {
        throw new RuntimeException('Could not get an access token from the metadata server.');
    }
    $data = json_decode($body, true);
    return $data['access_token'] ?? throw new RuntimeException('Token response was invalid.');
}

/** Translate text from Indonesian to Dutch. */
function translate(string $text): string
{
    $ch = curl_init('https://translation.googleapis.com/language/translate/v2');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => [
            'Authorization: Bearer ' . get_access_token(),
            'Content-Type: application/json',
        ],
        CURLOPT_POSTFIELDS     => json_encode([
            'q'      => $text,
            'source' => SOURCE_LANG,
            'target' => TARGET_LANG,
            'format' => 'text',
        ]),
        CURLOPT_TIMEOUT        => 15,
    ]);
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode((string) $body, true);
    if ($code !== 200 || !isset($data['data']['translations'][0]['translatedText'])) {
        $msg = $data['error']['message'] ?? 'Translation request failed (HTTP ' . $code . ').';
        throw new RuntimeException($msg);
    }
    return html_entity_decode($data['data']['translations'][0]['translatedText'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

$input  = trim($_POST['text'] ?? '');
$result = null;
$error  = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $input !== '') {
    if (mb_strlen($input) > MAX_CHARS) {
        $error = 'Text is too long (max ' . MAX_CHARS . ' characters).';
    } else {
        try {
            $result = translate($input);
        } catch (Throwable $e) {
            error_log('Translate error: ' . $e->getMessage());
            $error = 'Translation failed: ' . $e->getMessage();
        }
    }
}

function h(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Langomatic – Indonesian to Dutch</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 640px; margin: 3rem auto; padding: 0 1rem; color: #1a1a1a; }
        h1 { color: #2f5d50; }
        textarea { width: 100%; min-height: 8rem; padding: .75rem; font: inherit; box-sizing: border-box; }
        button { margin-top: .75rem; padding: .6rem 1.2rem; font: inherit; background: #2f5d50; color: #fff; border: 0; border-radius: 6px; cursor: pointer; }
        .box { margin-top: 1.5rem; padding: 1rem; border-radius: 6px; }
        .result { background: #eef6f3; }
        .error { background: #fdecea; color: #8a1c10; }
        small { color: #6b6b6b; }
    </style>
</head>
<body>
    <h1>Langomatic</h1>
    <p>Translate Indonesian to Dutch <small>(Indonesisch → Nederlands)</small></p>

    <form method="post">
        <textarea name="text" placeholder="Type an Indonesian sentence, e.g. Apa ayah minum teh" required><?= h($input) ?></textarea>
        <button type="submit">Translate</button>
    </form>

    <?php if ($result !== null): ?>
        <div class="box result">
            <strong>Nederlands:</strong>
            <p><?= nl2br(h($result)) ?></p>
        </div>
    <?php endif; ?>

    <?php if ($error !== null): ?>
        <div class="box error"><?= h($error) ?></div>
    <?php endif; ?>
</body>
</html>
