<?php

namespace Authentication;

use Authentication\Exception\NotLoggedInException;
use Entity\User;
use Html\StringEscaper;
use Service\Session;

abstract class AbstractUserAuthentication
{
    use StringEscaper;
    protected const SESSION_KEY = '__UserAuthentication__';
    protected const SESSION_USER_KEY = 'user';
    protected const LOGOUT_INPUT_NAME = 'logout';
    private ?User $user = null;

    public function __construct()
    {
        try {
            $val = $this->getUserFromSession();
            $this->user = $val;
        } catch (NotLoggedInException $e) {
        }
    }

    abstract public function loginForm(string $action, string $submitText = 'OK'): string;

    abstract public function getUserFromAuth(): User;

    protected function setUser(User $user): void
    {
        Session::start();
        $_SESSION[self::SESSION_KEY] = [];
        $_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY] = $user;
        $this->user = $user;
    }

    public function isUserConnected(): bool
    {
        Session::start();

        return isset($_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY]);
    }

    public function logoutForm(string $action, string $text): string
    {
        $logout = self::LOGOUT_INPUT_NAME;
        $html = <<<HTML
        <form action="$action" method="post">
            <button name="$logout">{$this->escapeString($text)}</button>
        </form>
        HTML;

        return $html;
    }

    public function logoutIfRequested(): void
    {
        Session::start();
        if (isset($_POST[self::LOGOUT_INPUT_NAME])) {
            $this->user = null;
            unset($_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY]);
        }
    }

    protected function getUserFromSession(): User
    {
        // Session::start() ; Quand on utilise $_SESSION
        Session::start();
        if (!isset($_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY])) {
            throw new NotLoggedInException("La session ne contient pas d'utilisateur");
        }

        return $_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY];
    }

    public function getUser(): User
    {
        if (null == $this->user) {
            throw new NotLoggedInException("La session ne contient pas d'utilisateur");
        }

        return $this->user;
    }
}
