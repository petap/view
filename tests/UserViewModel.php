<?php

namespace Petap\ViewTest;

use Laminas\View\Model\ViewModel;

class UserViewModel extends ViewModel
{
    private static $userIds = [];
    private static $users;

    public function setVariable($name, $value)
    {
        if ($name == 'userId') {
            self::$userIds[] = $value;
        }

        return parent::setVariable($name, $value);
    }

    public function getVariable($name, $default = null)
    {
        if ($name == 'name' || $name == 'countryId') {

            if (self::$users === null) {
                self::$users = $this->fetchUsers(self::$userIds);
            }
            $userId = $this->getVariable('userId');
            if (isset(self::$users[$userId][$name])) {
                return self::$users[$userId][$name];
            }
        }

        return parent::getVariable($name, $default);
    }

    private function fetchUsers($userIds)
    {
        $users = [
            'u1' => [
                'id' => 'u1',
                'name' => 'John',
                'countryId' => '1',
            ],
            'u2' => [
                'id' => 'u2',
                'name' => 'Helen',
                'countryId' => '2',
            ],
        ];

        $result = [];
        foreach ($userIds as $userId) {
            if (isset($users[$userId])) {
                $result[$userId] = $users[$userId];
            }
        }
        return $result;
    }
}
