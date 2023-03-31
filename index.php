<?php

require_once 'connec.php';
$pdo = new \PDO(DSN, USER, PASS);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = array_map('trim', $_POST);

    if (!isset($data['firstname']) || empty($data['firstname'])) {
        $errors[] = 'Il manque le Prénom.';
    } 

    if (strlen($data['firstname']) > 45 || strlen($data['lastname']) > 45) {
        $errors[] = 'Pas plus de 45 caractères pour le Prénom ou le Nom.';
    }

    if (!isset($data['lastname']) || empty($data['lastname'])) {
        $errors[] = 'Il manque le Nom.';
    } 

    if (empty($errors)) {
        $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
        $statement = $pdo->prepare($query);        
        $statement->bindValue(':firstname', $data['firstname'], \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $data['lastname'], \PDO::PARAM_STR);        
        $statement->execute();        
        header('location: index.php');
    }
    
    else {
        foreach ($errors as $error) {
            echo ($error);
        }
        die();
    }
}


// A exécuter afin d'afficher vos lignes déjà insérées dans la table friends

$query = "SELECT * FROM friend";

$statement = $pdo->query($query);

$friends = $statement->fetchAll();



// A exécuter afin d'insérer une ligne dans votre table friends




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header>
        <h1>Formulaire </h1>
    </header>

    <main>
    <div>
        <p>Ma liste d'amis</p>
            <ul>
            <?php foreach ($friends as $friend) : ?>
                <li><?= $friend['firstname'] . ' ' . $friend['lastname'] ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
        
    <form action="" method="post">           
         <p>
                <label for="firstname">Prénom :</label>
                <input type="text" id="firstname" name="firstname" required>
            </p>           
             <p>
                <label for="lastname">Nom :</label>
                <input type="text" id="lastname" name="lastname" required>
            </p>            
            <p class="button">
                <button type="submit">Enregistrer</button>
            </p>
        </form>
    </main>
</body>
</html>


   


