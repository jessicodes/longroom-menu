<?php
/**
 * Set db information
 */
class connect {

  protected $db_user = "root";
  protected $db_pass = "root";
  protected $db_host = "db";

  var $db_name = "longroom";

  public $library = array();

  /**
   * The constructor for this object. Specify local dev database vars
   * here if they don't match the database credentials on the production
   * server.
   */
  public function __construct()
  {
    $pdo = new PDO("mysql:dbname=" . $this->db_name . ";host=" . $this->db_host . "", $this->db_user, $this->db_pass);
    $this->library = new NotORM($pdo);
  }

  /**
   *   Method to connect to database
   *   @return bool designate successful connection to db
   */
  function connect_to_db() {
    if ($db = @mysql_connect( $this->db_host, $this->db_user, $this->db_pass )) {


      // if dev require diff db
      if (isset($_SERVER['DBNAME-DEV'])) {

        $this->db_name = $_SERVER['DBNAME-DEV'];

      }


      if (mysql_select_db($this->db_name,$db)) {
        //set utf-8
        mysql_set_charset('utf8');
        return $db;
      } else {
        // Failure
        echo "Failure: Could not select database.<BR>";
        // TO DO: handle failure here
      }
    } else {
      // Failure
      print("Failure: Could not connect to MySQL.<BR>");
      // TO DO: handle failure here
    }
  }

}
