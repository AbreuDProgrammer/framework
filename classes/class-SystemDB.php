<?

class SystemDB {

	private static $instance;
    private static $instanceDB;
	
    private $host;
    private $db_name;
    private $password;
    private $user;
    private $charset;
    private $pdo = null;
    private $error = null;
    private $debug = true;
    private $last_id = null;

    private function __construct($host = null, $db_name = null, $password = null, $user = null, $charset = null, $debug = null) 
    {
        $this->host = defined('HOSTNAME') ? HOSTNAME : $host;
        $this->db_name = defined('DB_NAME') ? DB_NAME : $db_name;
        $this->password = defined('DB_PASSWORD') ? DB_PASSWORD : $password;
        $this->user = defined('DB_USER') ? DB_USER : $user;
        $this->charset = defined('DB_CHARSET') ? DB_CHARSET : $charset;
        $this->debug = defined('DEBUG') ? DEBUG : $debug;

       $this->connect();
    }
	
	public static function getInstance(){
        if(isset(self::$instance))
            return self::$instance;
        return self::$instance = new SystemDB();
    }

    private static function getInstanceDB($d, $u, $p){
        if(!isset(self::$instance))
            self::$instance = new PDO($d, $u, $p);
        return self::$instance;
    }
	
    final protected function connect() {
        
        $pdo_details = "mysql:host={$this->host};";
        $pdo_details .= "dbname={$this->db_name};";
        $pdo_details .= "charset={$this->charset};";

        try {
			$this->pdo = self::getInstanceDB($pdo_details, $this->user, $this->password);
            unset($this->host);
            unset($this->db_name);
            unset($this->password);
            unset($this->user);
            unset($this->charset);

        } catch (PDOException $e) {
            if ($this->debug === true) {
                echo "Erro: " . $e->getMessage();
            }
            die();
        }
    }

    private function dataExists($table, $id){
        $test = $this->query("SELECT * FROM `$table` WHERE `id` = ?", array($id));
        if($test->fetch(PDO::FETCH_OBJ))
            return true;
        return false;
    }

    public function query($stmt, $data_a = null){

        $query = $this->pdo->prepare($stmt);
        
        $check_exec = $query->execute($data_a);

        if($check_exec)
            return $query;
        else {
            $error = $query->errorInfo();
            $this->error = $error[2];
            return false;
        }

    }

    public function insert($table) {
        
        $cols = array();
        
        $place_holders = '(';
        
        $values = array();
        
        $j = 1;
        
        $data = func_get_args();
        
        if (!isset($data[1]) || !is_array($data[1])) {
            return;
        }

        for ($i = 1; $i < count($data); $i++) {
            
            foreach ($data[$i] as $col => $val) {
                
                if ($i === 1) { 
                    $cols[] = "`$col`";
                }

                if ($j <> $i) {
                    
                    $place_holders .= '), (';
                }
                
                $place_holders .= '?, ';

                $values[] = $val;
                $j = $i;
            }
            
            $place_holders = substr($place_holders, 0, strlen($place_holders) - 2);
        }
        
        // Testa se existe
        $id = intval($data[1]["id"]);
        if($this->dataExists($table, $id)){
            return;
        }
        
        $cols = implode(', ', $cols);
        
        $stmt = "INSERT INTO `$table` ( $cols ) VALUES $place_holders) ";
    
        $insert = $this->query($stmt, $values);

        if ($insert) {
            
            if (method_exists($this->pdo, 'lastInsertId') && $this->pdo->lastInsertId()) {
                
                $this->last_id = $this->pdo->lastInsertId();
            }
            
            return $insert;
        }
        return;
    }

    public function update($table, $where_field, $where_field_value, $values){

        if(empty($table) || empty($where_field) || empty($where_field_value))
            return;

        $stmt = "UPDATE `$table` SET ";

        $set = array();

        $where = "WHERE `$where_field` = ? ";

        if(!is_array($values))
            return;

        foreach($values as $column => $value)
            $set[] = " `$column` = ? ";

        $set = implode(', ', $set);

        $values[] = $where_field_value;

        $values = array_values($values);

        $update = $this->query($stmt, $values);

        if($update)
            return $update;
        return;

    }

    public function delete($table, $where_field, $where_field_value){

        if(empty($table) || empty($where_field) || empty($where_field_value))
            return;

        $stmt = "DELETE FROM `$table` ";
        $where = " WHERE `$where_field` = ? ";
        $stmt .= $where;

        $values = array($where_field_value);
        $delete = $this->query($stmt, $values);
        
        if($delete)
            return $delete;
        return;
    }
}