<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style='text-align: center'>
        <p>Vous avez fait la demande de réinitialisation de votre mot de passe, pour cela veuillez cliquez sur le lien ci-dessous</p>
        <a href='http://localhost:8741/new-password?email=<?= $email ?>&code=<?= $code ?>'>Cliquez ici</a>
    </div>
</body>
</html>
