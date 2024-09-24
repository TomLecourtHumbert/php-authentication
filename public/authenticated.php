<?php

declare(strict_types=1);

use Authentication\UserAuthentication;
use Html\AppWebPage;

$authentication = new UserAuthentication();

// Un utilisateur est-il connecté ?
try {
    $user = $authentication->getUser();
} catch (Authentication\Exception\NotLoggedInException $e) {
    header('Location: form.php');
    exit; // Fin du programme
}

$title = 'Zone membre connecté';
$p = new AppWebPage($title);

$p->appendContent(<<<HTML
        <h1>$title</h1>
        <h2>Page 1</h2>
HTML
);
$p->appendContent(<<<HTML
            <p>Personne connectée : <a href="user.php">{$user->getFirstName()}</a></p>
HTML
);

echo $p->toHTML();
