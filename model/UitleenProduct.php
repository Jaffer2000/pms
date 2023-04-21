<?php
require_once("model/Database.php");

/**
 * Producten van het Uitleen systeem
 * @access public
 * @author Korben de Vos
 * @version 1.1
 *
 */
class UitleenProduct {

    /**
	 * @var short
     * id van een product
	 */
	private $product_id;

	/**
	 * @var String
     * naam van een product
	 */
	private $product_naam;


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
     * validateProductNaam
     * @access public
     *
     * @param $product_naam
     * @return void
     * @throws Exception
     */
    public function validateProductNaam($product_naam)
    {
        // validate product naam for other methods
        if (strlen($product_naam)< 1) throw new Exception ('Product naam is leeg' );
        if (strlen($product_naam)> 50) throw new Exception ('Product naam is te lang' );

    }

    /**
     * createProduct
     * @access public
     *
     * @param $product_naam
     * @return bool|void
     */
	public function createProduct($product_naam)
    {
        // maak product aan
        try {
            $this->validateProductNaam($product_naam);
            $sql = $this->connect()->prepare("INSERT INTO producten (product_naam) VALUES (?)");
            $sql->bind_param("s", $product_naam);
            $sql->execute();

        } catch (Exception $e) {

            // echo error message
            echo $e->getMessage();
            die;
        }

        return true;
	}

    /**
     * editProduct
     * @access public
     *
     * @param $product_id
     * @param $product_naam
     * @return bool|void
     */
	public function editProduct($product_id, $product_naam)
    {
        // pas product aan
        try {
            $this->validateProductNaam($product_naam);
            $sql = $this->connect()->prepare("UPDATE producten SET product_naam = ? WHERE product_id = ?");
            $sql->bind_param("si", $product_naam, $product_id);
            $sql->execute();

        } catch (Exception $e) {

            // echo error message
            echo $e->getMessage();
            die;
        }

        return true;
	}

    /**
     * deleteProduct
     * @access public
     *
     * @param $product_id
     * @return bool|void
     */
	public function deleteProduct($product_id)
    {
        // verwijder product
        try {
            $sql = $this->connect()->prepare("DELETE FROM producten WHERE product_id=(?)");
            $sql->bind_param("i", $product_id);
            $sql->execute();

        } catch (Exception $e) {

            // echo error message
            echo $e->getMessage();
            die;
        }

        return true;
	}

    /**
     * getAllProducts
     * @access public
     *
     * @return bool|mysqli_result|void
     */
	public function getAllProducts()
    {
        // get all producten
        try {
            $sql = "SELECT * FROM `producten`";
            $rows = mysqli_query($this->connect(), $sql);
        }  catch (Exception $e){

            // echo error message
            echo $e->getMessage();
            die;
        }

        return $rows;
	}

    /**
     * getLastLender
     * @access public
     *
     * @param $product_id
     * @return void
     */
	public function getLastLender($product_id)
    {
        /**
         * IN DEVELOPMENT
         *
         try {
            $sql = $this->connect()->prepare(
                "SELECT *
                        FROM aanvragen
                        INNER JOIN producten
                        ON aanvraag_producten.product_id = producten.product_id
                        INNER JOIN aanvraag_producten
                        ON
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
        */

	}
}
?>