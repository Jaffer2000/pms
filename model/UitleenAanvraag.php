<?php
require_once("model/Database.php");

/**
 * Aanvragen van het uitleensysteem
 * @access public
 * @author Korben de Vos
 * @version 1.0
 */
class UitleenAanvraag {
	/**
	 * @AttributeType int
     * ID van aanvraag
	 */
	private $aanvraag_id;

	/**
	 * @AttributeType Date
     * Begindatum van aanvraag
	 */
	private $datum_van;

	/**
	 * @AttributeType Date
     * Einddatum van aanvraag
	 */
	private $datum_tot;

	/**
	 * @AttributeType int
     * Status van aanvraag
	 */
	private $status = 0;


    /**
     * connect
     * @access private
     *
     * @return bool|mixed|mysqli
     */
    private function connect()
    {
        // create database connection for other methods
        $this->connection = new Database();
        $this->connection = $this->connection->connect();
        return $this->connection;
    }

    /**
     * createAanvraag
     *
     * @param $userid
     * @param $datumvan
     * @param $datumtot
     * @param $naamaanvraag
     * @return array|void
     */
	public function createAanvraag($datumvan, $datumtot, $naamaanvraag)
    {
        // maak aanvraag aan
        try {
            $sql = $this->connect()->prepare("CALL GETAANVRAGEN('$datumvan','$datumtot','$naamaanvraag');");
            $sql->execute();
            $sql->close();

            $aanvraag_id = new Database();
            $aanvraag_id = $aanvraag_id->getLastInsertedId();


        } catch (Exception $e) {

            // echo error message
            echo $e->getMessage();
            die;
        }
        return [true, $aanvraag_id];
	}

    /**
     * saveAanvraagProduct
     *
     * @param $aanvraag_id
     * @param $product_id
     * @return bool|void
     */
	public function saveAanvraagProduct($aanvraag_id, $product_id)
    {
        // link een product aan een aanvraag
        try {
            $sql = $this->connect()->prepare("INSERT INTO aanvraag_producten (aanvraag_id, product_id) VALUES (?, ?)");
            $sql->bind_param("ii", $aanvraag_id, $product_id);
            $sql->execute();

        } catch (Exception $e) {

            // echo error message
            echo $e->getMessage();
            die;
        }

        return true;
	}

    /**
     * getAllAanvragen
     *
     * @return bool|mysqli_result|void
     */
	public function getAllAanvragen()
{
    // get all aanvragen
    try {
        $sql = "SELECT * FROM `aanvragen` ORDER BY aanvraag_id DESC LIMIT 30";
        $result = mysqli_query($this->connect(), $sql);
        $aanvragen = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $aanvragen[] = $row;
        }
    } catch (Exception $e) {
        // echo error message
        echo $e->getMessage();
        die;
    }

    return $aanvragen;
}


    /**
     * getAanvraagProducten
     *
     * @param $aanvraag_id
     * @return array|void
     */
	public function getAanvraagProducten($aanvraag_id)
    {
        // get aanvraag producten
        try {
            $sql = $this->connect()->prepare(
                "SELECT aanvraag_producten.product_id, producten.product_naam 
                        FROM aanvraag_producten 
                        INNER JOIN producten 
                        ON aanvraag_producten.product_id = producten.product_id 
                        WHERE aanvraag_producten.aanvraag_id = ?");
            $sql->bind_param("i", $aanvraag_id);
            $sql->execute();
            $producten = $sql->get_result();
            $producten = $producten->fetch_all();
        }  catch (Exception $e){

            // echo error message
            echo $e->getMessage();
            die;
        }

        return $producten;
	}

    /**
     * changeAanvraagstatus
     *
     * @param $aanvraag_id
     * @param $status
     * @return bool|void
     */
    public function changeAanvraagstatus($aanvraag_id, $status)
    {
        // verander aanvraag status naar meegegeven status
        try {
            $sql = $this->connect()->prepare("UPDATE aanvragen set status = ? WHERE aanvraag_id = ?");
            $sql->bind_param("ii", $status, $aanvraag_id);
            $sql->execute();

        } catch (Exception $e) {

            // echo error message
            echo $e->getMessage();
            die;
        }

        return true;
    }

    /**
     * approveAanvraag
     *
     * @param $aanvraag_id
     * @return bool
     */
	public function approveAanvraag($aanvraag_id): bool
    {
        // 1 = goedgekeurd, 2 = ingeleverd, 3 = afgekeurd
        $this->changeAanvraagstatus($aanvraag_id, 1);

        return true;
	}

    /**
     * @param $aanvraag_id
     * @return bool
     */
	public function disapproveAanvraag($aanvraag_id): bool
    {
        // 1 = goedgekeurd, 2 = ingeleverd, 3 = afgekeurd
        $this->changeAanvraagstatus($aanvraag_id, 3);

        return true;
	}

    /**
     * setProductsHandedIn
     *
     * @param $aanvraag_id
     * @return bool
     */
	public function setProductsHandedIn($aanvraag_id): bool
    {
        // 1 = goedgekeurd, 2 = ingeleverd, 3 = afgekeurd
        $this->changeAanvraagstatus($aanvraag_id, 2);

        return true;
	}
    
// public function getNaam(){
//     // selecteer naam
//     try {
//         $naam = $sql = "SELECT naamaanvraag FROM `aanvragen` ORDER BY aanvraag_id DESC LIMIT 30";
//         $naam = mysqli_query($this->connect(), $sql);
//     }  catch (Exception $e){

//         // echo error message
//         echo $e->getMessage();
//         die;
//     }

//     return $naam;
// }

public function getAanvraagNaamList() {
    $return_array = array();

        $query = "SeLeCt * FrOm `aanvragen` limit 1;";
        $result = $this->connect()->query($query);
        // For all database results:
        foreach ($result as $idx => $array){
            // Nieuw object
            $lijst = new UitleenAanvraag();
            // Set info
            $lijst->setNaam($array['naamaanvraag']);

            // Add new object to return array.
            $return_array[] = $lijst;
        }
        return $return_array;
}

public function setNaam($naam) {
    $this->naam = $naam;
}

public function getNaam() {
    return $this->naam;
}
    
public function getStatusLabel($status)
{
    if ($status == 1) {
        return 'Goedgekeurd';
    } elseif ($status == 2) {
        return 'Ingeleverd';
    } elseif ($status == 3) {
        return 'Afgekeurd';
    } else {
        return '';
    }
}
}

