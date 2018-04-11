<?php
// Update your path to your DB connector if required
include("db.php");

abstract class ManagerDB {
    public static $table_name;

    public static function dosql($sql, $vals = false) {
        $db = connect_pdo();
        $result = null;
        try {
            $stmt = $db->prepare($sql);
            if ($vals) {
                $stmt->execute($vals);
            } else {
                $stmt->execute();
            }

        } catch (PDOException $e) {
            $stmt = false;
        }
        $db = null;

        return $stmt;
    }

    // Get a record from the DB using ID
    public static function get($id) {
        $sql = "select * from ". static::$table_name . " where id = ?";
        return self::dosql($sql, array($id))->fetch();
    }

    // Get all records from the DB
    public static function all() {
        $sql = "select * from ". static::$table_name;
        return self::dosql($sql)->fetchAll();
    }

    // Delete a record using ID
    public static function delete($id) {
        $sql = "delete from ". static::$table_name . " where id = ?";
        return self::dosql($sql, array($id))->fetch();
    }

    // Update a specific column by ID
    public static function update_one($col_name, $value, $id) {
        $sql = "update " . static::$table_name . " set $col_name = ? where id = ?";
        return self::dosql($sql, array($value, $id));
    }
}


/**
 * New ManagerDB can be created by extending the ManagerDB Abstract class
 * You just need to change update the table name
 * If you require special functions to process before saving in your DB, add them 
 * in the extended ManagerDB
 * 
 * For example for User Manager DB
 */

class UserManagerDB extends ManagerDB {
    public static $table_name = "user";

    public static function get_by_username($username) {
        $sql = "select * from " . static::$table_name . " where username = ?";
        return self::dosql($sql, array($username))->fetch();
    }

    public static function create($username, $password) {
        $password = User::hash_password($password);
        $sql = "insert into ". static::$table_name . "(username, password, block) values(?, ?, ?)";
        return self::dosql($sql, array($username, $password, 0));
    }

}

class MessageManagerDB extends ManagerDB {
    public static $table_name = "message";
}

class CompanyManagerDB extends ManagerDB {
    public static $table_name = "company";
}
