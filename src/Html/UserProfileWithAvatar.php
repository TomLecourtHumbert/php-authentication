<?php

namespace Html;

class UserProfileWithAvatar extends UserProfile
{
    public function toHtml(): string
    {
        $html = parent::toHtml();
        $html .= <<<HTML
        <style>#avatar {position:relative;
                        left:60%;
                        bottom: 280px;}
               img {width: 40%;
                    height:auto}</style>
        <div id="avatar">
        <img src="avatar.php?userId={$this->getUser()->getId()}" alt="Avatar">
        </div>
        HTML;
        return $html;

    }
}
