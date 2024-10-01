<?php

namespace Authentication;

use Entity\User;

class UserAuthentication extends AbstractUserAuthentication
{
    private const LOGIN_INPUT_NAME = 'login';
    // const == {readOnly}
    private const PASSWORD_INPUT_NAME = 'password';

    public function loginForm(string $action, string $submitText = 'OK'): string
    {
        $login = self::LOGIN_INPUT_NAME;
        $password = self::PASSWORD_INPUT_NAME;
        $html = <<<HTML
        <form action="$action" method="post">
            <input placeholder="Login" type="text" name="$login" value="">
            <input placeholder="Pass" type="password" name="$password" value="">
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
}
