<?php

namespace P5blog\models;

final class User extends AbstractEntity
{
    public int $id;
    public int $admin;
    public string $name;
    public string $email;
    public string $password;
    public string $creationdate;

    public static function retrieveFromName(array $data): ?self
    {
        $user = new self($data);

        $db = self::dbconnect();
        $query = $db->prepare('SELECT * FROM user WHERE name = :name');
        $query->bindValue(':name', $user->name, \PDO::PARAM_STR);
        $query->execute();
        $response = $query->fetch(\PDO::FETCH_ASSOC);

        if (!$response) {
            throw new \Exception("Impossible de récupérer l'utilisateur'");
        }

        $user->hydrate($response);

        return $user;
    }

    public static function retrieveFromEmail(array $data): ?self
    {
        $user = new self($data);
        $db = self::dbconnect();
        $query = $db->prepare('SELECT * FROM user WHERE email = :email');
        $query->bindValue(':email', $user->email, \PDO::PARAM_STR);
        $query->execute();
        $response = $query->fetch(\PDO::FETCH_ASSOC);

        if (!$response) {
            throw new \Exception("Impossible de récupérer l'utilisateur'");
        }

        $user->hydrate($response);

        return $user;
    }

    public static function retrieveAll(): ?array
    {
        $db = self::dbconnect();
        $query = $db->prepare('SELECT * FROM user');
        $query->execute();

        return $query->fetchall(\PDO::FETCH_CLASS);
    }

    public static function createOne(array $data): bool
    {
        $user = new self($data);
        $user->securePassword();

        if ($user->verifyName()) {
            throw new \Exception("Ce nom existe déjà");
        }

        if ($user->verifyEmail()) {
            throw new \Exception("Cette adresse existe déjà");
        }

        $db = self::dbconnect();

        $query = $db->prepare('INSERT INTO user (name, password, email, creationdate, admin) VALUES (:name, :password, :email, NOW(), 0)');
        $query->bindValue(':name', $user->name, \PDO::PARAM_STR);
        $query->bindValue(':password', $user->password, \PDO::PARAM_STR);
        $query->bindValue(':email', $user->email, \PDO::PARAM_STR);

        return $query->execute();
    }

    public static function deleteOne(int $id): bool
    {
        $db = self::dbconnect();
        $query = $db->prepare('DELETE FROM user WHERE id = :id');
        $query->bindValue(':id', $id, \PDO::PARAM_INT);

        return $query->execute();
    }

    public function securePassword(): void
    {
        $this->password = password_hash(trim($this->password), PASSWORD_DEFAULT);
    }

    public function verifyPassword($password): bool
    {
        return password_verify($password, $this->password);
    }

    public function verifyName(): bool
    {
        $db = self::dbconnect();
        $query = $db->prepare('SELECT * FROM user WHERE name = :name');
        $query->bindValue(':name', $this->name, \PDO::PARAM_STR);
        $query->execute();

        return (bool)$query->fetch(\PDO::FETCH_ASSOC);
    }

    public function verifyEmail(): bool
    {
        $db = self::dbconnect();
        $query = $db->prepare('SELECT * FROM user WHERE email = :email');
        $query->bindValue(':email', $this->email, \PDO::PARAM_STR);
        $query->execute();

        return (bool)$query->fetch(\PDO::FETCH_ASSOC);
    }
}
