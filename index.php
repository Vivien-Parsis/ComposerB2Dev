<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Composer</title>
</head>
<body>
    <h2>Form de  validation de composer.json</h2>
    <form method="POST" action="">
        <label for="composerJsonPath">Chemin vers composer.json :</label>
        <input type="text" name="composerJsonPath" required><br>

        <label for="lang">Langue :</label>
        <input type="text" name="lang" required><br>

        <button type="submit">Valider</button>
    </form>
</body>
</html>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $composerJsonPath = $_POST['composerJsonPath'];
        $lang = $_POST['lang'];
        $output = [];
        $returnCode = null;
        exec("php bin/console composer:validate $composerJsonPath --lang=$lang", $output, $returnCode);
        $result = implode("\n", $output);
        echo <<<HTML
        <pre>
            {$result}
        </pre>
HTML;
    }
?>