<?php

namespace Service;

class Session
{
    public static function start(): void
    {
        if (PHP_SESSION_NONE === session_status()) {
            if (headers_sent()) {
                throw new Exception\SessionException('Vous avez déjà envoyé des informations sur le serveur');
            } else {
                session_start();
            }
        } elseif (PHP_SESSION_ACTIVE !== session_status()) {
            throw new Exception\SessionException("Le serveur n'accepte pas les sessions");
        }
    }
}
