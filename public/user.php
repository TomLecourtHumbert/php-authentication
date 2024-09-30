<?php

declare(strict_types=1);

use Authentication\UserAuthentication;
use Html\AppWebPage;
use Html\UserProfileWithAvatar;

$authentication = new UserAuthentication();

$p = new AppWebPage('');

try {
    // Tentative de connexion
    $user = $authentication->getUser();
    $userProfile = new UserProfileWithAvatar($user, $_SERVER['PHP_SELF']);
    $userProfile->updateAvatar();
    // Si connexion réussie, affichage du profil
    $p->appendContent($userProfile->toHTML());
    $p->setTitle('Profil de '.$user->getFirstName());
} catch (Authentication\Exception\NotLoggedInException $e) {
    // Récupération de l'exception si connexion échouée
    header('Location: form.php');
} catch (Exception $e) {
    $p->appendContent("Un problème est survenu&nbsp;: {$e->getMessage()}");
}

// Envoi du code HTML au navigateur du client
echo $p->toHTML();
