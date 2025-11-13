<?php

namespace repository;
use bdd\Bdd;
use model\InformationHoraire;
use PDO;
require_once "../model/InformationHoraire.php";

class InformationHoraireRepository
{
    /** @var PDO */
    private $db;

    public function __construct(?PDO $pdo = null)
    {
        $this->db = $pdo instanceof PDO ? $pdo : (new Bdd())->getBdd();
    }


    public function create(InformationHoraire $informationHoraire){
        $stmt = $this->db->prepare('INSERT INTO informationHoraire (id, date, heureDebut, heureFin) VALUES (:id, :date, :heureDebut, :heureFin)');
        $stmt->execute([
            'id' => $informationHoraire->getId(),
            'date' => $informationHoraire->getDateJour(),
            'heureDebut' => $informationHoraire->getHeureDebut(),
            'heureFin' => $informationHoraire->getHeureFin(),
            'idEmploye' => $informationHoraire->getRefEmployee() ,
            'minuteTravaille' => $informationHoraire->getMinuteTravaille(),
            'creeLe' => $informationHoraire->getCreeLe()
        ]);
    }

}