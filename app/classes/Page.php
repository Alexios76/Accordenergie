<?php

namespace App;


class Page
{
    private \Twig\Environment $twig;
    public $pdo;
    public Session $session;

    function __construct()
    {

        $prefixe = str_contains(getcwd(), 'admin') ? "../" : "";

        $this->session = new Session();

        try {
            $this->pdo = new \PDO('mysql:host=mysql;dbname=accordenergie', "root", "");
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            die();
        }
        // $this->session = new Session();
        $loader = new \Twig\Loader\FilesystemLoader($prefixe . '../templates');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => $prefixe . '../var/cache/compilation_cache',
            'debug' => true
        ]);
    }

    public function insert(string $table_name, array $data)
    {
        $sql = " INSERT INTO " . $table_name . " (email, password, name, surname, phone_number) 
                                                VALUES (:email, :password, :name, :surname, :phone_number)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function render(string $name, array $data): string
    {
        return $this->twig->render($name, $data);
    }

    public function getUserByEmail(array $data)
    {
        $sql = "SELECT * FROM user WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM user";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $users;
    }
}
