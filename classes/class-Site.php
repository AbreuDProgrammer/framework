<? 

class Site
{
    private static $instances = array();
    private $data;

    private function __construct($data){
        $this->data = $data;
    }

    //* Apenas um site por id
    public static function getInstance($data){
        if(isset(self::$instances[$data["id"]]))
            return self::$instances[$data["id"]];
        return self::$instances[$data["id"]] = new Site($data);
    }

    public function getId(){
        return $this->data["id"] ?? null;
    }

    public function getName(){
        return $this->data["name"] ?? null;
    }

    public function getDescription(){
        return $this->data["description"] ?? null;
    }

    public function getLink(){
        return $this->data["link"] ?? null;
    }

    //* Retorna um site pelo ID
    public static function getById($id){
        return self::$instances[$id] ?? null;
    }

    public function setName($name){
        $this->data["name"] = $name;
    }

    public function setDescription($description){
        $this->data["description"] = $description;
    }

    public function setLink($link){
        $this->data["link"] = $link;
    }
}