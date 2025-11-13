<?php

namespace model;

class InformationHoraire
{
    private $id;
    private $ref_employee;
    private $dateJour;
    private $heure_debut;
    private $heure_fin;
    private $minute_travaille;
    private $cree_le;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getRefEmployee()
    {
        return $this->ref_employee;
    }

    /**
     * @param mixed $ref_employee
     */
    public function setRefEmployee($ref_employee)
    {
        $this->ref_employee = $ref_employee;
    }

    /**
     * @return mixed
     */
    public function getDateJour()
    {
        return $this->dateJour;
    }

    /**
     * @param mixed $dateJour
     */
    public function setDateJour($dateJour)
    {
        $this->dateJour = $dateJour;
    }

    /**
     * @return mixed
     */
    public function getHeureDebut()
    {
        return $this->heure_debut;
    }

    /**
     * @param mixed $heure_debut
     */
    public function setHeureDebut($heure_debut)
    {
        $this->heure_debut = $heure_debut;
    }

    /**
     * @return mixed
     */
    public function getHeureFin()
    {
        return $this->heure_fin;
    }

    /**
     * @param mixed $heure_fin
     */
    public function setHeureFin($heure_fin)
    {
        $this->heure_fin = $heure_fin;
    }

    /**
     * @return mixed
     */
    public function getMinuteTravaille()
    {
        return $this->minute_travaille;
    }

    /**
     * @param mixed $minute_travaille
     */
    public function setMinuteTravaille($minute_travaille)
    {
        $this->minute_travaille = $minute_travaille;
    }

    /**
     * @return mixed
     */
    public function getCreeLe()
    {
        return $this->cree_le;
    }

    /**
     * @param mixed $cree_le
     */
    public function setCreeLe($cree_le)
    {
        $this->cree_le = $cree_le;
    }

}