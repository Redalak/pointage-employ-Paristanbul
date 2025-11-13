<?php

namespace repository;
use bdd\Bdd;
use model\Employee;
use model\InformationHoraire;
use PDO;
require_once "../model/Employee.php";


class EmployeeRepository
{
    /** @var PDO */
    private $db;

    public function __construct(?PDO $pdo = null)
    {
        $this->db = $pdo instanceof PDO ? $pdo : (new Bdd())->getBdd();
    }
    public function create(Employee $employee){
        $stmt = $this ->db -> prepare("INSERT into employees(nom_complet,qr_token, role, active,cree_le,updated_at)");
        $stmt->execute([
            'nom_complet' => $employee->getNomComplet(),
            'qr_token' => $employee->getQrToken(),
            'role' => $employee->getRole(),
            'active' => $employee->getActive(),
            'cree_le' => $employee->getCreeLe(),
            'updated_at' => $employee->getUpdatedAt()
        ]);
    }
}