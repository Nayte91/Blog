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
    private $logged;

    public static function retrieveFromName(string $name): ?self
    {
        $db = self::dbconnect();
        $query = $db->prepare('SELECT * FROM user WHERE name = :name');
        $query->bindValue(':name', $name, \PDO::PARAM_STR);
        $query->execute();
        $response = $query->fetch(\PDO::FETCH_ASSOC);

        if ($response) {
          return new self($response);
        }

        return null;
    }

    public static function retrieveAll(): array
    {
      $db = self::dbconnect();
      $query = $db->prepare('SELECT * FROM user');
      $query->execute();
      $response = $query->fetchall(\PDO::FETCH_CLASS);

      return $response;
    }

    public static function createOne(array $data): ?self
    {
        $db = self::dbconnect();
        $query = $db->prepare('SELECT * FROM user WHERE name = :name');
        $query->bindValue(':name', $data['name'], \PDO::PARAM_STR);
        $query->execute();
        $nameresponse = $query->fetch(\PDO::FETCH_ASSOC);

        if ($nameresponse) {
          throw new \Exception("Ce nom existe déjà");
        }

        $query = $db->prepare('SELECT * FROM user WHERE email = :email');
        $query->bindValue(':email', $data['email'], \PDO::PARAM_STR);
        $query->execute();
        $emailresponse = $query->fetch(\PDO::FETCH_ASSOC);

        if ($emailresponse) {
          throw new \Exception("Cette adresse existe déjà");
        }

        throw new \Exception("Petit canaillou");
    }

    public function setId($id): void
    {
        $this->id = $id;
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
