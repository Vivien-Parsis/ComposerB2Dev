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
    <label for="composerJsonContent">Contenu JSON de composer.json :</label>
        <textarea id="composerJsonContent" name="composerJsonContent" required></textarea><br>
        <label for="lang">Langue :</label>
        <select name="lang" id="lang">
            <option value="en">en</option>
            <option value="fr">fr</option>
            <option value="de">de</option>
        </select><br>
        <button type="submit">Valider</button>
    </form>
</body>
</html>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $composerJsonContent = $_POST['composerJsonContent'];
        $lang = $_POST['lang'];
        $tempFile = tempnam("../".sys_get_temp_dir(), 'composer_json_');
        file_put_contents($tempFile, $composerJsonContent);
        $output = [];
        $returnCode = null;
        exec("php ../bin/console composer:validate $tempFile --lang=$lang", $output, $returnCode);
        unlink($tempFile);
        $result = implode("\n", $output);
    }
?>