<?php

use Html\AppWebPage;

$p = new AppWebPage('Avatar');

try {
    if (isset($_GET['userId'])) {
        header('Content-type: image/png');
        $ava = Entity\UserAvatar::findById($_GET['userId']);
        echo $ava->getAvatar();
    } else {
        header('Content-type: image/png');
        echo file_get_contents('img/default_avatar.png');
    }
} catch (Entity\Exception\EntityNotFoundException $e) {
    header('Content-type: image/png');
    echo file_get_contents('img/default_avatar.png');
}
