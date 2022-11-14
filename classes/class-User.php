<? 

class User
{
    private static $instances = array();
    private $data = array();

    private function __construct($userdata)
    {
        $this->data["id"] = $userdata["id"];
        $this->data["session_id"] = $userdata["session_id"];
        $this->data["username"] = $userdata["username"];
        $this->data["permission"] = $userdata["permission"];
        $this->data["password"] = $userdata["password"];
    }

    //* Se o user com o mesmo ID já existir retorna esse user ao invés de criar
    public static function getInstance($userdata){
        if(isset(self::$instances[$id]) && self::$instances[$id] !== null)
            return self::$instances[$id];
        return self::$instances[$id] = new User($userdata);
    }

    public function getId(){
        return $this->data["id"];
    }

    public function getSessionId(){
        return $this->data["session_id"];
    }

    public function getUsername(){
        return $this->data["username"];
    }

    public function getpermissions(){
        return $this->data["permissions"];
    }

    public function setSessionId($session_id){
        $this->data["session_data"] = $session_id;
    }

    public function setUsername($username){
        $this->data["username"] = $username;
    }

    public function setPermission($permission){
        $this->data["permission"] = $permission;
    }

    public function setPassword($password){
        $this->data["password"] = $password;
    }

}