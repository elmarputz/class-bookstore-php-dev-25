<?php

namespace Data;

use Bookshop\Category;
use Bookshop\Book;
use Bookshop\User;
use PDO;


class DataManager implements IDataManager
{


    private static $connection;

    private static function getConnection() : \PDO {
        if (!self::$connection) {
            $type = 'mysql';
            $host = 'db';
            $database = 'db';
            $user = 'db';
            $password = 'db';

            self::$connection = new \PDO("$type:host=$host;dbname=$database;charset=utf8", $user, $password);

        }
        return self::$connection;
    }


    private static function lastInsertId($connection) : int {
        return $connection->lastInsertId();
    }

    private static function fetchObject ($cursor) {
        return $cursor->fetchObject();
    }

    private static function close($cursor) : void {
        $cursor->closeCursor();
    }

    private static function closeConnection()
    {
        self::$connection = null;
    }


    private static function query (\PDO $connection, string $query, array $parameters = []) : \PDOStatement {
        try {
            $statement = $connection->prepare($query);
            $i = 1;
            foreach ($parameters as $param) {
                if (is_int($param)) {
                    $statement->bindValue($i, $param, \PDO::PARAM_INT);
                }
                if (is_string($param)) {
                    $statement->bindValue($i, $param, \PDO::PARAM_STR);
                }
                $i++;
            }
            $statement->execute();
        }
        catch (\PDOException $e) {
            die($e->getMessage());
        }
        return $statement;
    }

    public static function getCategories(): array
    {
       $categories = [];
       $con = self::getConnection();
       $res = self::query($con, "SELECT id, name FROM categories");

       while ($cat = self::fetchObject($res)) {
           $categories[] = new Category($cat->id, $cat->name);
       }
       self::close($res);
       self::closeConnection();
       return $categories;
    }

    public static function getBooksByCategory(int $categoryId): array
    {
        // TODO: Implement getBooksByCategory() method.
    }

    public static function getUserById(int $userId): ?User
    {
        // TODO: Implement getUserById() method.
    }

    public static function getUserByUserName(string $userName): ?User
    {
        // TODO: Implement getUserByUserName() method.
    }

    public static function createOrder(int $userId, array $bookIds, string $nameOnCard, string $cardNumber): int
    {
        // TODO: Implement createOrder() method.
    }
}