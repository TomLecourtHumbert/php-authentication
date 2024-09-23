<?php

namespace Authentication;

use Entity\User;
use Html\StringEscaper;

class UserAuthentication
{
    use StringEscaper;
    private const LOGIN_INPUT_NAME = 'login';
    private const PASSWORD_INPUT_NAME = 'password';

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
        return User::findByCredentials($_POST['login'], $_POST['password']);
    }
}
