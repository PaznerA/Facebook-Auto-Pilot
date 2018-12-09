<?php declare(strict_types = 1);

namespace Fb2CMS\Model;

use Dibi\Exception;
use Fb2CMS\Controller\Helper;
use Fb2CMS\Model\Database as DB;

class User
{
    /** @var \Fb2CMS\Model\Database $Database */
    protected $DB;

    /** @var string $AccessToken */
    protected $AccessToken;

    /** @var \DateTime $TokenExpiresAt */
    protected $TokenExpiresAt;

    /** @var int $UserId */
    protected $UserId;

    /** @var \DateTime $LastLogin */
    protected $LastLoginAt;

    public function __construct($tempToken, $userId)
    {
        $this->DB = DB::getConnection();
        $this->login($userId, $tempToken);
    }

    private function login($userId, $tempToken)
    {
        $userLoaded = $this->getUser($userId);
        if ($userLoaded !== true) {
            $this->removeUser($userId);
            $this->addUser($userId, $tempToken);
            $this->getUser($userId);
        }

    }

    /**
     * @param int $userId
     * @throws \Dibi\Exception
     *
     */
    private function getUser($userId)
    {
        $row = $this->DB->nativeQuery('SELECT * FROM tokens WHERE user_id = "' . $userId . '"');
        $vyst = $row->fetchAll();
        if (count($vyst) === 1) {
            $this->UserId = $vyst[0]->user_id;
            $this->AccessToken = $vyst[0]->token;
            $this->LastLoginAt = new \DateTime();
            $this->TokenExpiresAt = \DateTime::createFromFormat('U', $vyst[0]->expires_at);
            return true;
        }
        return false;
    }

    private function addUser($userId, $token)
    {
        $data = Helper::extendToken($token);
        $expireAt = time() - 3600 + (int) $data->expires_in;
        $resp = $this->DB->insert(
            'tokens',
            [
                'user_id' => $userId,
                'token' => $data->access_token,
                'expires_at' => $expireAt,
            ]);
        try {
            $resp->execute();
            return true;
        } catch (Exception $e) {
            die('Nastala chyba při ukládání uživatele!');
        }
    }

    private function removeUser($userId)
    {
        $this->DB->nativeQuery('DELETE FROM tokens WHERE user_id = "' . $userId . '"');
        return true;
    }

    public function checkTokenExpiration()
    {
        $safeTime = new \DateTime();
        $safeTime->modify('+ 1 week');
        if ($this->TokenExpiresAt <= $safeTime) {
            return false;
        }
        return true;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->AccessToken;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->UserId;
    }


}