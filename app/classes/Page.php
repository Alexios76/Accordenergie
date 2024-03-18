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

        $loader = new \Twig\Loader\FilesystemLoader($prefixe . '../templates');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => $prefixe . '../var/cache/compilation_cache',
            'debug' => true
        ]);
    }

    public function insert(string $table_name, array $data)
    { 
    
    $sql = " INSERT INTO " . $table_name . " (email, password, name, surname, phone_number, user_type) 
                                                VALUES (:email, :password, :name, :surname, :phone_number, :user_type)";
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


    public function getPdo()
    {
        return $this->pdo;
    }


 

public function getAllUsers($userType = null) {
    $sql = "SELECT * FROM user";
    if ($userType !== null) {
        $sql .= " WHERE user_type = :user_type";
    }
    $stmt = $this->pdo->prepare($sql);
    if ($userType !== null) {
        $stmt->bindValue(':user_type', $userType);
    }
    $stmt->execute();
    $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $users;
}

    public function deleteUser($user_id)
{
    $sql = "DELETE FROM user WHERE user_id = :user_id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
}

public function updateUserPassword(array $data) {
    $sql = "UPDATE user SET password = :password WHERE email = :email";
    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute($data);
}

public function deleteIntervention($intervention_id)
{
    $sql = "DELETE FROM intervention WHERE intervention_id = :intervention_id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['intervention_id' => $intervention_id]);
}

// Ajouter cette méthode dans la classe Page
public function addIntervention($date_intervention, $nature_intervention, $description, $street_and_number, $adress_complement, $code_postal, $ville, $societe, $degre_urgence_id, $status_id, $user_id, $id_standardiste, $id_intervenant)
{
    // Préparer la requête SQL pour insérer une nouvelle intervention
    $sql = "INSERT INTO intervention (date_intervention, nature_intervention, description, street_and_number, adress_complement, code_postal, ville, societe, degre_urgence_id, status_id, user_id, id_standardiste, id_intervenant) 
            VALUES (:date_intervention, :nature_intervention, :description, :street_and_number, :adress_complement, :code_postal, :ville, :societe, :degre_urgence_id, :status_id, :user_id, :id_standardiste, :id_intervenant)";
    
    // Préparer et exécuter la requête avec les valeurs des paramètres
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        'date_intervention' => $date_intervention,
        'nature_intervention' => $nature_intervention,
        'description' => $description,
        'street_and_number' => $street_and_number,
        'adress_complement' => $adress_complement,
        'code_postal' => $code_postal,
        'ville' => $ville,
        'societe' => $societe,
        'degre_urgence_id' => $degre_urgence_id,
        'status_id' => $status_id,
        'user_id' => $user_id,
        'id_standardiste' => $id_standardiste,
        'id_intervenant' => $id_intervenant
    ]);
}

public function getStandardistes(){
    $sql = "SELECT * FROM user WHERE user_type = 'standardiste'";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $standardistes = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $standardistes;
}
public function getIntervenants(){
    $sql = "SELECT * FROM user WHERE user_type = 'intervenant'";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $intervenants = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $intervenants;
}

public function getClients(){
    $sql = "SELECT * FROM user WHERE user_type = 'client'";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $clients = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $clients;
}


public function getAllDegreUrgence(){
    $sql = "SELECT * FROM degreurgence";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $degre_urgence_list = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $degre_urgence_list;
}

// Ajoutez cette méthode dans la classe Page
public function getAllStatusTypes(){
    $sql = "SELECT * FROM statut";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $statusTypes = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    return $statusTypes;
}


}