<?php

namespace Authentication;

use Html\Helper\Random;

class SecureUserAuthentication extends AbstractUserAuthentication
{
    private const CODE_INPUT_NAME = 'code';
    private const SESSION_CHALLENGE_KEY = 'challenge';
    private const RANDOM_STRING_SIZE = 16;

    public function loginForm(string $action, string $submitText = 'OK'): string
    {
        $login = self::SESSION_CHALLENGE_KEY;
        $login = Random::class->generate(self::RANDOM_STRING_SIZE);
        $html = <<<HTML
        <form action="$action" method="post">
            <input placeholder="Login" type="text" id="log" name="" value="">
            <input placeholder="Pass" type="password" id="pass" name="" value="">
            <input placeholder="Challenge" type="hidden" id="chl" name="" value="$login">
            <input placeholder="Code" type="hidden" id="code" name="code" value="">
            <button>{$this->escapeString($submitText)}</button>
        </form>
        HTML;

        return $html;
    }
}
