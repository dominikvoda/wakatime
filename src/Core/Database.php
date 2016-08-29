<?php
/**
 * Copyright (C) Dominik Voda - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Dominik Voda <d.voda94@gmail.com>
 *
 * Created by PhpStorm.
 * Date: 12.08.2016
 * Time: 20:36
 */

namespace WakaTime;


use WakaTime\Exceptions\PDOException;
use WakaTime\Interfaces\IDatabase;

class Database implements IDatabase
{
    const TABLE_PROJECT = "wt_projects";
    const TABLE_PROJECT_DAY = "wt_project_days";

    const ENTITY_CREATED = 1;
    const ENTITY_UPDATED = 2;

    private $connectionParameters;

    public function __construct(Config $config)
    {
        $this->connectionParameters = $config->get("database");
    }

    public function getProject($id)
    {
        $query = "SELECT * FROM " . self::TABLE_PROJECT . " WHERE id = :projectId";
        $connection = $this->createConnection($this->connectionParameters);
        $stm = $connection->prepare($query);
        $stm->bindParam(":projectId", $id, \PDO::PARAM_INT);
        $exec = $stm->execute();
        return ($exec) ? $stm->fetch() : false;
    }

    public function getProjectByTitle($title){
        $query = "SELECT * FROM " . self::TABLE_PROJECT . " WHERE title = :title";
        $connection = $this->createConnection($this->connectionParameters);
        $stm = $connection->prepare($query);
        $stm->bindParam(":title", $title, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch();
    }

    public function getProjectDay($projectTitle, \DateTime $day)
    {
        $projectId = $this->getProjectByTitle($projectTitle)['id'];
        $query = "SELECT * FROM " . self::TABLE_PROJECT_DAY . " WHERE project_id = :projectId AND day_date = :day";
        $connection = $this->createConnection($this->connectionParameters);
        $stm = $connection->prepare($query);
        $stm->bindParam(":projectId", $projectId);
        $stm->bindParam(":day", $day->format("Y-m-d"));
        $exec = $stm->execute();
        return ($exec) ? $stm->fetch() : false;
    }

    public function createProject($title, $hours = 0)
    {
        $query = "INSERT INTO " . self::TABLE_PROJECT . " (title, total_hours) VALUES";
        $query .= "(:title, :hours)";
        $connection = $this->createConnection($this->connectionParameters);
        $stm = $connection->prepare($query);
        $stm->bindParam(":title", $title, \PDO::PARAM_STR);
        $stm->bindParam(":hours", $hours);
        $stm->execute();
        return $connection->lastInsertId();
    }

    public function updateProject($title, $data)
    {
        if($this->getProjectByTitle($title)){
            return self::ENTITY_UPDATED;
        }
        else{
            $this->createProject($data['title']);
            return self::ENTITY_CREATED;
        }
    }

    public function createProjectDay($data, $day)
    {
        $projectId = $this->getProjectByTitle($data->name)['id'];
        if(!$projectId){
            $projectId = $this->createProject($data->name, $data->total_seconds);
        }

        $query = "INSERT INTO " . self::TABLE_PROJECT_DAY . " (project_id, day_date, hours) VALUES";
        $query .= "(:projectId, :day, :hours)";
        $connection = $this->createConnection($this->connectionParameters);
        $stm = $connection->prepare($query);
        $stm->bindParam(":projectId", $projectId);
        $stm->bindParam(":day", $day, \PDO::PARAM_STR);
        $stm->bindParam(":hours", $data->total_seconds);
        $stm->execute();
        return $connection->lastInsertId();
    }

    public function updateProjectDay($data, $date)
    {
        $day = new \DateTime($date);
        $projectDay = $this->getProjectDay($data->name, $day);
        if($projectDay){
            $query = "UPDATE " . self::TABLE_PROJECT_DAY . " SET hours = :hours WHERE project_id = :projectId AND day_date = :day";
            $connection = $this->createConnection($this->connectionParameters);
            $stm = $connection->prepare($query);
            $stm->bindParam(":hours", $data->total_seconds);
            $stm->bindParam(":projectId", $projectDay['project_id']);
            $stm->bindParam(":day", $projectDay['day_date'], \PDO::PARAM_STR);
            $stm->execute();
            return self::ENTITY_UPDATED;
        }
        else{
            $this->createProjectDay($data, $day->format("Y-m-d"));
            return self::ENTITY_CREATED;
        }
    }

    public function getProjectProjectDays($projectTitle){
        $projectId = $this->getProjectByTitle($projectTitle)['id'];
        $query = "SELECT * FROM " . self::TABLE_PROJECT_DAY . " WHERE project_id = :projectId";
        $connection = $this->createConnection($this->connectionParameters);
        $stm = $connection->prepare($query);
        $stm->bindParam(":projectId", $projectId);
        $stm->execute();
        return $stm->fetchAll();
    }

    public function getDateRangeProjectDays($from, $to){
        $query = "SELECT * FROM " . self::TABLE_PROJECT_DAY . " WHERE day_date >= :from AND day_date <= :to";
        $connection = $this->createConnection($this->connectionParameters);
        $stm = $connection->prepare($query);
        $stm->bindParam(":from", $from);
        $stm->bindParam(":to", $to);
        $stm->execute();
        return $stm->fetchAll();
    }

    private function createConnection($parameters){
        try{
            $host = $parameters['host'];
            $user = $parameters['user'];
            $password = $parameters['password'];
            $dbName = $parameters['database_name'];
            return new \PDO("mysql:dbname={$dbName};host={$host}", $user, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
        }
        catch (\PDOException $e){
            throw new PDOException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

}