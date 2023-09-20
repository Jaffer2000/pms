<?php
require_once ("model/Database.php");

/**
 * Studenten van het PMS,
 *
 * @access public
 * @author Korben de Vos
 * @version 1.1
 *
 */
class User
{


    /**
     * @var int
     * id van student
     */
    private $id;

    /**
     * @var string
     * gebruikersnaam van student
     */
    private $username;

    /**
     * @var string
     * naam van student
     */
    private $name;

    /**
     * @var string
     * email van student
     */
    private $email;

    /**
     * @var string
     * accounttype van student
     */
    private $accounttype;

    /**
     * @var string
     * wachtwoord van student
     */
    private $password;


    /**
     * connect
     * @access private
     *
     * @return bool|mixed|mysqli
     */
    private function connect(){

        // create database connection for other methods
        $this->connection = new Database();
        $this->connection = $this->connection->connect();
        return $this->connection;
    }

    /**
     * getUserUsername
     * @access public
     * @param $userid
     *
     * @return mixed|void
     */
    public function getUserUsername($userid) {
        // get student gebruikersnaam
        try {
            $sql = $this->connect()->prepare("SELECT `naam` FROM `users` WHERE `username` = ?");
            $sql->bind_param("s", $userid);
            $sql->execute();
            $username = $sql->get_result();
            $username = $username->fetch_assoc();
            $username = $username['naam'];
        }  catch (Exception $e){

            // echo error message
            echo $e->getMessage();
            die;
        }

        return $username;
    }

    public function getAllStudents() {
        try {
            $sql = $this->connect()->prepare("SELECT `username`, `naam` FROM `users` WHERE `accounttype` IN (?, ?)");
            $accountTypes = array('Student', 'IVS Managament');
            $sql->bind_param("ss", $accountTypes[0], $accountTypes[1]);
            $sql->execute();
            $result = $sql->get_result();
    
            $students = array();
            while ($row = $result->fetch_assoc()) {
                $students[] = $row;
            }
    
            return $students;
        } catch (Exception $e) {
            // Handle the exception, log the error, or return an empty array based on your requirement.
            return array();
        }
    }
}