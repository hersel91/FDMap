<?php

namespace App\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Connection;

class CredentialsService
{
    private $fdConn;
    private $mapEM;

    public function __construct(Connection $fdConn, EntityManager $mapEM)
    {
        $this->fdConn = $fdConn;
        $this->mapEM = $mapEM;
    } 

    public function updateCredentials($login)
    {
        $statement = $this->fdConn->prepare("
            SELECT user_pass 
            FROM wp_users
            WHERE user_login = '$login'
        ");
        $result = $statement->execute();
        $response = $statement->fetchAll();
        if(count($response) == 0) return;
        $password = $response[0]['user_pass'];

        $user = $this->mapEM->getRepository("App:FDUser")->findOneByLogin($login);
        if(is_null($user)) {
            $user = (new FDUser())
                ->setLogin($login)
                ->setPassword($password)
                ->setNickname($login);
            $em->persist($user);
        } else {
            $user->setPassword($password);
        }
        $this->mapEM->flush(); 
    }
}