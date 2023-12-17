<?php
// Make By Bonus
class ORMSimple
{
    protected $conn;
    protected $arry = [];

    protected function sendJson(array $data = [], int $rowCount)
    {
        $json = [
            "rowCount" => $rowCount,
            "data" => $data,
        ];
        return $json;
    }


    public function __construct($host, $username, $password, $database)
    {
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo "Error: $e";
        }
    }


    public function fetchAllData(string $table)
    {
        try {
            $sql = $this->conn->prepare("SELECT * FROM $table");
            $sql->execute();
            $data = $sql->fetchAll();
            return $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }





    public function fetchByOne(string $table = null, array $conditions = [], bool $getall = false)
    {
        if ($table !== null && !empty($conditions)) {
            try {
                $whereConditions = [];
                foreach ($conditions as $column => $value) {
                    $whereConditions[] = "$column = :$column";
                }
                $whereClause = implode(' AND ', $whereConditions);

                $sql = $this->conn->prepare("SELECT * FROM $table WHERE $whereClause");

                foreach ($conditions as $column => $value) {
                    $sql->bindValue(":$column", $value);
                }

                $sql->execute();
                if ($getall == false) {
                    return $sql->fetch();
                } else {
                    return $sql->fetchAll();
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Sorry, please enter Table and Conditions.";
        }
    }

    public function addData(string $table = null, array $data = [])
    {
        if ($table !== null && !empty($data)) {
            try {
                $columns = implode(', ', array_keys($data));
                $placeholders = ':' . implode(', :', array_keys($data));

                $sql = $this->conn->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");

                foreach ($data as $key => $value) {
                    $sql->bindValue(":$key", $value);
                }

                $sql->execute();
                return true;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false;
            }
        } else {
            echo "Sorry, please enter Table and Data.";
            return false;
        }
    }
    
    public function deleteData(string $table, array $conditions) {
        if ($table !== null && !empty($conditions)) {
            try {
                $whereConditions = [];
                foreach ($conditions as $column => $value) {
                    $whereConditions[] = "$column = :$column";
                }
                $whereClause = implode(' AND ', $whereConditions);

                $sql = $this->conn->prepare("DELETE FROM $table WHERE $whereClause");

                foreach ($conditions as $column => $value) {
                    $sql->bindValue(":$column", $value);
                }
                $sql->execute();
                return true;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Sorry, please enter Table and Conditions.";
        }
    }

    public function updateData(string $table = null, array $updateData = [], array $conditions = [])
    {
        if ($table !== null && !empty($updateData) && !empty($conditions)) {
            try {
                $updateColumns = [];
                foreach ($updateData as $column => $value) {
                    $updateColumns[] = "$column = :$column";
                }
                $updateSet = implode(', ', $updateColumns);

                $whereConditions = [];
                foreach ($conditions as $column => $value) {
                    $whereConditions[] = "$column = :where_$column";
                }
                $whereClause = implode(' AND ', $whereConditions);

                $sql = $this->conn->prepare("UPDATE $table SET $updateSet WHERE $whereClause");

                foreach ($updateData as $column => $value) {
                    $sql->bindValue(":$column", $value);
                }

                foreach ($conditions as $column => $value) {
                    $sql->bindValue(":where_$column", $value);
                }

                $sql->execute();
                return true;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false;
            }
        } else {
            echo "Sorry, please enter Table, Update Data, and Conditions.";
            return false;
        }
    }
}
// Make By Bonus