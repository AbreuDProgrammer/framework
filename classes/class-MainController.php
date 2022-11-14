<?

abstract class MainController
{
    private $acao;
    private $model;
    private $iterator;

    public $parametros = array();
    public static $title = null;
    public static $js = null;

    public function __construct($parametros = array(), $acao = "index")
    {
        $this->parametros = $parametros;

        $this->acao = $acao;

        $this->iterator = MyIterator::getInstance();
    }

    public function base()
    {
        $this->load_view("header");

        $this->load_view("menu");
        
        $this->load_view("login-navbar");

        $this->{$this->acao}();

        $this->load_view("footer");
    }

    protected function load_view($view){
        if(!$view)
            return;

        $view = strtolower($view);

        $path = ABSPATH.'/views/_includes/'.$view.'.html';
        
        if(!file_exists($path))
            $path = ABSPATH.'/views/_includes/'.$view.'.php';

        if(!file_exists($path))
            $path = ABSPATH.'/views/'.$view.'/'.$view.'-view.php';
            
        if(!file_exists($path))
            return;

        require_once $path;
    }

    protected abstract function index();

    protected function load_model($model_name = false) {

        if (!$model_name)
            return;
            
        // Garante que o nome do modelo tenha letras minúsculas
        $model_name = strtolower($model_name);

        $model_path = ABSPATH.'/models/'.$model_name.'.php';

        // Verifica se o ficheiro existe
        if (file_exists($model_path)) {

            require_once $model_path;

            //* Gera o objeto
            $model_name = explode('/', $model_name);
            $model_name = end($model_name);
            $model_name = preg_replace('/[^a-zA-Z0-9]/is', '', $model_name);

            if (class_exists($model_name)) {

                // Retorna um objeto da classe
                return $this->model = new $model_name($this->parametros);
            }
        }
    }
}