<?php

namespace Chatbot\Repository;
use MainRepository;
use PDO;

require_once 'MainRepository.php';

class UserRepository extends MainRepository {

    public function isCombinaisonValid($login,$password) :bool{
        $passwordDB = $this->getPasswordUser($login);
        return password_verify($password, $passwordDB);
    }

    public function getPasswordUser($login){
        $req = 'SELECT password FROM c_user WHERE login = :login';
        $prep = $this->getDataBase()->prepare($req);
        $prep->bindValue(':login', $login, PDO::PARAM_STR);
        $prep->execute();
        $res = $prep->fetch(PDO::FETCH_ASSOC);
        $prep->closeCursor();
        return $res['password'];
    }

    public function getUtilisateurInformation($login){
        $req = 'SELECT * FROM c_user WHERE login = :login';
        $prep = $this->getDataBase()->prepare($req);
        $prep->bindValue(':login', $login, PDO::PARAM_STR);
        $prep->execute();
        $res = $prep->fetch(PDO::FETCH_ASSOC);
        $prep->closeCursor();
        return $res;
    }

    public function verifLoginDisonible($login): bool
    {
        $utilisateur = $this->getUtilisateurInformation($login);
        return empty($utilisateur);
    }

    public function bdCreerCompte($login, $passwordCrypte, $mail, $role): bool{
        $req = "INSERT INTO c_user (login, password, role) VALUES (:login, :password, 'admin')";
        $stmt = $this->getDataBase()->prepare($req);
        $stmt->bindValue(":login", $login, PDO::PARAM_STR);
        $stmt->bindValue(':password', $passwordCrypte, PDO::PARAM_STR);
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
        $stmt->execute();
        $estModifier = ($stmt->rowCount() > 0 );
        $stmt->closeCursor();
        return $estModifier;
    }

    public function bdSuppressionCompte($login): bool
    {
        $req="DELETE FROM c_user WHERE login = :login";
        $stmt = $this->getDataBase()->prepare($req);
        $stmt->bindValue(':login', $login, PDO::PARAM_STR);
        $stmt->execute();
        $estModifier = ($stmt->rowCount() > 0 );
        $stmt->closeCursor();
        return $estModifier;
    }

    public function setLastConnection($login): bool
    {
        $req = 'UPDATE c_user SET last_connection = NOW() WHERE login = :login ';
        $stmt = $this->getDataBase()->prepare($req);
        $stmt->bindValue(':login', $login, PDO::PARAM_STR);
        $stmt->execute();
        $estModifier = ($stmt->rowCount() > 0);
        $stmt->closeCursor();
        return $estModifier;
    }

    public function alreadyConnected(): bool
    {
        $req = 'SELECT last_connection FROM c_user WHERE id = :id';
        $stmt = $this->getDataBase()->prepare($req);
        $stmt->bindValue(':id', 1);
        $stmt->execute();
        $res = $stmt->fetch();
        $stmt->closeCursor();
        if (!empty($res['last_connection'])){
            return true;
        } else {
            return false;
        }
    }

    public function updateUser($login, $password){
        $req = 'UPDATE c_user SET login = :login, password = :password WHERE id = :id';
        $stmt = $this->getDataBase()->prepare($req);
        $stmt->bindValue(':login', $login);
        $stmt->bindValue(':password',$password);
        $stmt->bindValue(':id', 1, PDO::PARAM_INT);
        $stmt->execute();
    }
}