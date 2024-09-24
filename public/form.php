<?php

declare(strict_types=1);

use Authentication\UserAuthentication;
use Html\AppWebPage;

// Création de l'authentification
$authentication = new UserAuthentication();

$authentication->logoutIfRequested();

$p = new AppWebPage('Authentification');

// Production du formulaire de connexion
$p->appendCSS(<<<CSS
    form input {
        width : 4em ;
    }
CSS
);

try {
    $user = $authentication->getUser();
    $p->appendContent('<p>Personne connectée : '.$user->getLastName());
    $form2 = $authentication->logoutForm('form.php', 'Déconnexion');
    $p->appendContent(<<<HTML
        {$form2}
    HTML
    );
} catch (Authentication\Exception\NotLoggedInException $e) {
    $form = $authentication->loginForm('auth.php');
    $p->appendContent(<<<HTML
        {$form}
        <p>Pour faire un test : essai/toto
    HTML
    );
}

echo $p->toHTML();
