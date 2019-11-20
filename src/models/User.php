<?php

namespace P5blog\models;

final class User extends AbstractEntity
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $admin;
    private $creationdate;

    public static function retrieveFromName(array $data): ?self
    {
        $user = new self($data);
        $db = self::dbconnect();
        $query = $db->prepare('SELECT * FROM user WHERE name = :name');
        $query->bindValue(':name', $user->name, \PDO::PARAM_STR);
        $query->execute();
        $response = $query->fetch(\PDO::FETCH_ASSOC);

        if ($response) {
            $user->id = $response['id'];
            $user->name = $response['name'];
            $user->email = $response['email'];
            $user->password = $response['password'];
            $user->creationdate = $response['creationdate'];
            $user->admin = $response['admin'];
            return $user;
        } else {
            return null;
        }
    }

    public static function retrieveFromEmail(array $data): ?self
    {
        $user = new self($data);
        $db = self::dbconnect();
        $query = $db->prepare('SELECT * FROM user WHERE email = :email');
        $query->bindValue(':email', $user->email, \PDO::PARAM_STR);
        $query->execute();
        $response = $query->fetch(\PDO::FETCH_ASSOC);

        if ($response) {
            $user->id = $response['id'];
            $user->name = $response['name'];
            $user->email = $response['email'];
            $user->password = $response['password'];
            $user->creationdate = $response['creationdate'];
            $user->admin = $response['admin'];

            return $user;
        } else {
            return null;
        }
    }

    public static function retrieveAll(): ?array
    {
        $db = self::dbconnect();
        $query = $db->prepare('SELECT * FROM user');
        $query->execute();
        $response = $query->fetchall(\PDO::FETCH_CLASS);

        return $response;
    }

    public static function createOne(array $data): bool
    {
        $user = new self($data);

        if (self::retrieveFromName($data)) {
            throw new \Exception("Ce nom existe déjà");
        }

        if (self::retrieveFromEmail($data)) {
            throw new \Exception("Cette adresse existe déjà");
        }

        $db = self::dbconnect();
        $query = $db->prepare('INSERT INTO user (name, password, email, creationdate, admin) VALUES (:name, :password, :email, NOW(), 0)');
        $query->bindValue(':name', $user->name, \PDO::PARAM_STR);
        $query->bindValue(':password', $user->password, \PDO::PARAM_STR);
        $query->bindValue(':email', $user->email, \PDO::PARAM_STR);

        return $query->execute();
    }

    public static function deleteFromId(int $id): ?bool
    {
        $db = self::dbconnect();
        $query = $db->prepare('DELETE FROM user WHERE id = :id');
        $query->bindValue(':id', $id, \PDO::PARAM_INT);

        return $query->execute();
    }

    public function setId($id): void
    {
        $this->id = (int)$id;
    }

    public function setName(?string $name): void
    {
        $len = mb_strlen($name);

        if (($len > 3) || ($len < 16)){
            $this->name = ucfirst(trim($name));
        } else {
            throw new \Exception("Login invalide");
        }
    }

    public function setEmail($email): void
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->email = $email;
        } else {
            throw new \Exception("C'est une adresse mail ça ?");
        }
    }

    public function setPassword($password): void
    {
        $this->password = password_hash(trim($password), PASSWORD_DEFAULT);
    }

    public function setAdmin($admin): void
    {
        $this->admin = (int) $admin;
    }

    public function setCreationdate($creationdate): void
    {
        $this->creationdate = $creationdate;
    }

    public function getAll(): ?array
    {
        return get_object_vars($this);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getAdmin(): ?int
    {
        return $this->admin;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function verifyPassword($password): bool
    {
        return password_verify($password, $this->password);
    }
}
