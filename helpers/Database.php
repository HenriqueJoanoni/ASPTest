<?php

namespace ASPHelper;

class Database
{
    private static $_pdo;

    /**
     * @return \PDO
     */
    public static function getInstance()
    {
        if (!isset(self::$_pdo)) {
            self::$_pdo = new \PDO("mysql:host=127.0.0.1;dbname=asptest", "root", "SimpleS_root2019@");
        }
        return self::$_pdo;
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param int $age
     * @param string $password
     * @return false|string
     */
    public function addNewUser(string $firstName, string $lastName, string $email, int $age, string $password)
    {
        $connection = self::getInstance();
        $stmt = $connection->prepare(
            'INSERT INTO people(first_name, last_name, email, age, password) VALUES (?, ?, ?, ?, ?)'
        );

        $stmt->bindParam(1, $firstName);
        $stmt->bindParam(2, $lastName);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $age);
        $stmt->bindParam(5, $password);
        $stmt->execute();

        return $connection->lastInsertId();
    }

    /**
     * @param string $newEncriptedPassword
     * @param int $userId
     * @return void
     */
    public function updatePassword(string $newEncriptedPassword, int $userId)
    {
        $connection = self::getInstance();

        $stmt = $connection->prepare(
            'UPDATE people SET password = ? WHERE id = ?'
        );

        $stmt->bindParam(1, $newEncriptedPassword);
        $stmt->bindParam(2, $userId);
        $stmt->execute();
    }

    /**
     * @param int $int
     * @return null
     */
    public function checkIfUserExists(int $int)
    {
        $connection = Database::getInstance();

        $stmt = $connection->prepare(
            'SELECT id FROM people WHERE id = ?'
        );

        $stmt->bindParam(1, $int);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(\PDO::FETCH_OBJ)){
                    return $row->id;
                }
            }
        }

        return null;
    }
}