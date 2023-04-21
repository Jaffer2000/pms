<?php

/**
 * Deze klasse maakt een connectie met de database aan
 * @access public
 * @author Korben de Vos
 * @version 0.1
 *
 */
class Database
{

    /**
     * connect
     * @access public
     *
     * @return mixed|mysqli
     */
    function connect () {
        static $conn;
        if ($conn===NULL){
            // maak connectie string met gegevens van de database en de database gebruiker
            $servername = "localhost";
            $username = "root";
            $password = "";
            $db = "ivsuitleensysteem";

            // maak connectie met opgegeven gegevens
            $conn = new mysqli($servername, $username, $password, $db);
        }
        return $conn;
    }

    /**
     * getLastInsertedId
     * @access public
     *
     * @return int|string
     */
    function getLastInsertedId() {
        $conn = $this->connect();

        return mysqli_insert_id($conn);
    }

}