<?php

namespace App;


class Page
{
    private \Twig\Environment $twig;
    private $pdo;
    public Session $session;

    function __construct()
    {

        $this->session = new Session();
        
        try {
            $this->pdo = new \PDO('mysql:host=mysql;dbname=accordenergie', "root", "");
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            die();
        }

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => '../var/cache/compilation_cache',
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

    public function render(string $name, array $data) :string
    {
        return $this->twig->render($name, $data);
    }

    public function getUserByEmail(array $data){
        $sql = "SELECT * FROM user WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    

}