<?

class Login
{
    private static $instance;
    private $logged_in = false;
    private $user;

    //* Apenas pode existir um login
    public static function getInstance(){
        if(isset(self::$instance))
            return self::$instance;

        $userdata = self::checkLogin();
        if(!$userdata)
            return null;
            
        return self::$instance = new Login($userdata);
    }

    public function __construct($userdata){
        $this->logged_in = true;
        $this->user = User::getInstance($userdata);
    }

    private static function checkLogin(){
        if(!isset($_POST["userdata"]))
            return false;
        
        if($_POST["userdata"] == null)
            return false;

        if(!is_array($_POST["userdata"]))
            return false;

        if(!isset($_POST["userdata"]["id"]) && !isset($_POST["userdata"]["password"]))
            return false;

        $userdata = $_POST["userdata"];
        unset($_POST["userdata"]);
        $_SESSION["userdata"] = $userdata;
        return $userdata;
    }

    private function logout(){
        unset(self::$instance);
        session_regenerate_id();
        unset($_SESSION["userdata"]);
    }

    public function checkPermission($necessary){
        $permission = $this->user->getPermission();
        if($permission < $necessary)
            return false;
        return true;
    }
}