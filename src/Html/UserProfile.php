<?php

namespace Html;

use Entity\User;

class UserProfile
{
    use StringEscaper;
    // Use dans la classe quand c'est un trait, les méthodes de StringEscaper
    // deviennent des méthodes pour UserProfile
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function toHtml(): string
    {
        $html = <<<HTML
        <body>
            <p>Nom
            <blockquote>{$this->escapeString($this->getUser()->getLastName())}</blockquote></p>
            <p>Prénom
            <blockquote>{$this->escapeString($this->getUser()->getFirstName())}</blockquote></p>
            <p>Login
            <blockquote>{$this->escapeString($this->getUser()->getLogin())}</blockquote></p>
            <p>Téléphone
            <blockquote>{$this->escapeString($this->getUser()->getPhone())}</blockquote></p>
        </body>
        HTML;

        return $html;
    }
}
