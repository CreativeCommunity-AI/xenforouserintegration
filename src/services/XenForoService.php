<?php
namespace CreativeCommunityAI\xenforouserintegration\services;

use craft\base\Component;
use yii\db\Connection;
use creativecommunityai\xenforouserintegration\XenForoUserIntegration;

class XenForoService extends Component
{
    private $db;

    public function init(): void
    {
        parent::init();

        $settings = XenForoUserIntegration::$plugin->getSettings();

        $this->db = new Connection([
            'dsn' => 'mysql:host=' . $settings->dbHost . ';dbname=' . $settings->dbName,
            'username' => $settings->dbUsername,
            'password' => $settings->dbPassword,
            'charset' => 'utf8',
        ]);
    }

    public function authenticateUser($username, $password)
    {
        $user = $this->findUserByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            $user['groups'] = $this->getUserGroups($user['user_id']);
            return $user;
        }
        return null;
    }

    public function findUserByUsername($username)
    {
        return $this->db->createCommand('SELECT * FROM xf_user WHERE username=:username')
            ->bindValue(':username', $username)
            ->queryOne();
    }

    public function getUserGroups($userId)
    {
        return $this->db->createCommand('SELECT group_id FROM xf_user_group_relation WHERE user_id=:user_id')
            ->bindValue(':user_id', $userId)
            ->queryColumn();
    }
}