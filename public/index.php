<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Composer</title>
</head>
<body>
    <h2>Form de  validation de composer.json</h2>
    <form method="POST" action="" enctype="multipart/form-data">
    <label for="composerJson">composer.json :</label>
        <input id="composerJson" name="composerJson" type="file" required accept=".json"><br>
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
    function getComposer(){
        if ($_FILES['composerJson']['error'] === UPLOAD_ERR_OK){
            if($_FILES['composerJson']['name']!="composer.json"){
                echo <<<HTML
                <p>
                    no composer.json file
                </p>
HTML;
                return;
            }
            $composerJson = $_FILES['composerJson']['tmp_name'];
            $lang = $_POST['lang'];
            $output = [];
            $returnCode = null;
            exec("php ../bin/console composer:validate $composerJson --lang=$lang", $output, $returnCode);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        getComposer();
    }
?>