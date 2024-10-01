<?php

namespace Html;

use Entity\User;
use Entity\UserAvatar;

class UserProfileWithAvatar extends UserProfile
{
    public const AVATAR_INPUT_NAME = 'avatar';
    private string $formAction;

    public function __construct(User $user, string $formAction)
    {
        parent::__construct($user);
        $this->formAction = $formAction;
    }

    public function toHtml(): string
    {
        $avatar = self::AVATAR_INPUT_NAME;
        $html = parent::toHtml();
        $html .= <<<HTML
        <style></style>
        <form action="{$this->formAction}" method="post" enctype='multipart/form-data'>
            Changer :
            <input accept='.png' type="file" name="$avatar" value="">
            <p><button>Mettre à jour</button>
        </form>
        <div id="avatar">
        <img src="avatar.php?userId={$this->getUser()->getId()}" alt="Avatar">
        </div>
        HTML;

        return $html;
    }

    public function updateAvatar(): bool
    {
        /*var_dump($_SESSION);
        var_dump($_FILES);*/
        if (isset($_FILES[self::AVATAR_INPUT_NAME])) {
            if (UPLOAD_ERR_OK === $_FILES[self::AVATAR_INPUT_NAME]['error'] && $_FILES[self::AVATAR_INPUT_NAME]['size'] > 0 && is_uploaded_file($_FILES[self::AVATAR_INPUT_NAME]['tmp_name'])) {
                $user = $this->getUser();
                $user_avatar = UserAvatar::findById($user->getId());
                $user_avatar->setAvatar(file_get_contents($_FILES[self::AVATAR_INPUT_NAME]['tmp_name']));
                unlink($_FILES[self::AVATAR_INPUT_NAME]['tmp_name']);

                return true;
            }
        }

        return false;
    }
}
