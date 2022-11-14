<? 

class MyIterator
{
    private static $instance;
    private $objs = array();
    private $key = 0;

    private function __construct(){}

    public static function getInstance(){
        if(!isset(self::$instance))
            self::$instance = new MyIterator();
        return self::$instance;
    }

    public function addObjs(Array $objs){
        $this->objs = $objs;
        $this->key = 0;
    }

    public function goNext(){
        if(count($this->objs) < $key)
            return $this->objs[$key];
        $this->key++;
        return $this->objs[$key];
    }

    public function goPrevious(){
        if($key <= 0)
            return $this->objs[$key];
        $this->key--;
        return $this->objs[$key];
    }

    public function goTo($key){
        if(!isset($this->objs[$key]))
            return;
        $this->key = $key;
        return $this->objs[$key];
    }

    public function showCurrent(){
        return $this->objs[$this->key];
    }

    public function hasNext(){
        return isset($this->objs[++$this->key]);
    }

    public function hasPrevious(){
        return isset($this->objs[--$this->key]);
    }
}