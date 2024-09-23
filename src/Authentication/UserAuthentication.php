<?php

namespace Authentication;

use Entity\User;
use Html\StringEscaper;
use Service\Session;

class UserAuthentication
{
    use StringEscaper;
    private const LOGIN_INPUT_NAME = 'login';
    // const == {readOnly}
    private const PASSWORD_INPUT_NAME = 'password';
    private const SESSION_KEY = '__UserAuthentication__';
    private const SESSION_USER_KEY = 'user';
    private const LOGOUT_INPUT_NAME = 'logout';
    private ?User $user = null;

    public function loginForm(string $action, string $submitText = 'OK'): string
    {
        $login = self::LOGIN_INPUT_NAME;
        $password = self::PASSWORD_INPUT_NAME;
        $html = <<<HTML
        <form action="$action" method="post">
            <input placeholder="Login" type="text" name="$login" value="">
            <input placeholder="Pass" type="text" name="$password" value="">
            <button>{$this->escapeString($submitText)}</button>
        </form>
        HTML;

        return $html;
    }

    public function getUserFromAuth(): User
    {
        $res = User::findByCredentials($_POST['login'], $_POST['password']);
        $this->setUser($res);
        return $res;
    }

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
            unset($_SESSION[self::SESSION_KEY][self::SESSION_USER_KEY]);
        }
    }
}
