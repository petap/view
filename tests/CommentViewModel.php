<?php

namespace Petap\ViewTest;

use Laminas\View\Model\ViewModel;

class CommentViewModel extends ViewModel
{
    public function getVariable($name, $default = null)
    {
        if ($name == 'userId') {
            $comment = $this->getVariable('comment');

            return $comment['userId'];
        }

        return parent::getVariable($name, $default);
    }
}
