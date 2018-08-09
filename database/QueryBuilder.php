<?php

namespace Petomatic\Database;

/**
 * Class QueryBuilder - it makes queries to database
 */
class QueryBuilder
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return array
     */
    public function getOwners()
    {
        $query = $this->pdo->prepare("SELECT `id`, `name` FROM `customers`");
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @return array
     */
    public function getPetsByOwner($id)
    {
        $q = $this->pdo->prepare("SELECT * FROM `pets` WHERE owner_id='{$id}'");
        $q->execute();
        return $q->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getVisitTypes()
    {
        $q = $this->pdo->prepare("SELECT * FROM `visit_types` WHERE 1");
        $q->execute();
        return $q->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param string $email
     * @return object
     */
    public function getOneUser($email)
    {
        $query = $this->pdo->prepare("SELECT * FROM `doctors` WHERE email='{$email}'");
        $query->execute();
        return $query->fetch(\PDO::FETCH_OBJ);
    }

    public function todaysVisits()
    {
        $query = $this->pdo->prepare("SELECT * FROM `visits`");
        $query->execute();
        $visits = $query->fetchAll(\PDO::FETCH_ASSOC);
        $today = time();
        $today = date('j M Y', $today);
        foreach ($visits as $key => $value) {
            $visits[$key]['date'] = date('j M Y', $value['date']);
        };
        foreach ($visits as $key => $value) {
            if ($value['date'] !== $today) {
                array_splice($visits, $key, 1);
            }
        };
        foreach ($visits as $key => $value) {
            $q = $this->pdo->prepare("SELECT * FROM `customers` WHERE id={$value['customer_id']}");
            $q->execute();
            $visits[$key]['customer_id'] = $q->fetchAll(\PDO::FETCH_ASSOC);
            $visits[$key]['customer_id'] = $visits[$key]['customer_id'][0];
            $qq = $this->pdo->prepare("SELECT * FROM `pets` WHERE id={$value['pet_id']}");
            $qq->execute();
            $visits[$key]['pet_id'] = $qq->fetchAll(\PDO::FETCH_ASSOC);
            $visits[$key]['pet_id'] = $visits[$key]['pet_id'][0];
            $qqq = $this->pdo->prepare("SELECT * FROM `visit_types` WHERE id={$value['pet_id']}");
            $qqq->execute();
            $visits[$key]['visit_type_id'] = $qqq->fetchAll(\PDO::FETCH_ASSOC);
            $visits[$key]['visit_type_id'] = $visits[$key]['visit_type_id'][0];
        };
        return $visits;
    }

    /**
     * @param array $data
     * @return boolean
     */
    public function addVisit($data)
    {
        $mysql = sprintf("INSERT INTO `visits` (%s) VALUES (%s)",
            implode(", ", array_keys($data)),
            ":" . implode(", :", array_keys($data))
            );
        $query = $this->pdo->prepare($mysql);
        $query->execute($data);
        return $query->debugDumpParams();
    }

    /**
     * @param $payload
     */
    public function updateVisit($payload)
    {
        //TODO
        // - one row in recipes
        // - connections in pivot table

        // and $query->debugDumpParams();
    }
}