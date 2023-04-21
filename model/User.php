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
            $sql = $this->connect()->prepare("SELECT naam FROM `users` WHERE id = ?");
            $sql->bind_param("i", $userid);
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

}