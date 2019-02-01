<?php
/**
 * Set db information
 */
class connect {

  protected $db_user = "longroom";
  protected $db_pass = "palindromeL32123";
  protected $db_host = "localhost";

  var $db_name = "longroom";

  public $library = array();

  /**
   * The constructor for this object. Specify local dev database vars
   * here if they don't match the database credentials on the production
   * server.
   */
  public function __construct()
  {
    //$this->connect_to_db();
    $pdo = new PDO("mysql:dbname=" . $this->db_name . ";host=" . $this->db_host . "", $this->db_user, $this->db_pass);
    $this->library = new NotORM($pdo);
  }

}
