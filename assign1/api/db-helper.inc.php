<?php
class DBHelper
{
    public static function createConnection($conn)
    {
        try {
            $pdo = new PDO($conn);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            die("connection error " . $e->getMessage());
        }


    }

    public static function runQuery($conn, $sql, $params)
    {
        $statement = null;
        if (isset($params)) {
            if (!is_array($params)) {
                $params = array($params);
            }
            $statement = $conn->prepare($sql);
            $statementCheck = $statement->execute($params);
            if (!$statementCheck) {
                throw new PDOException();
            }
        } else {
            $statement = $conn->query($sql);
            if (!$statement) {
                throw new PDOException();
            }
        }
        return $statement;
    }
}

?>