<?

class System 
{
    private $controlador; //primeira parte do $_GET['path'] é usado para gerenciar qual é a pagina
    private $acao; // segunda parte do $_GET['path'] é usado para gerenciar se houver alguma ação qual é
    private $parametros; // resto do $_GET['path'] é usado para em uma ação saber qual o parametros da função

    public function __construct() 
    {
        
        //* Obtém os valores do controlador, ação e parâmetros da HOME_URI.
        //* E configura as propriedades da classe.
        //* $this->controlador, $this->acao e $this->parametros
        $this->get_url_data();
    
        //* Verifica se o controlador existe. Caso contrário, adiciona o
        //* controlador padrão (controllers/home-controller.php) e chama o método index()
        if (!$this->controlador) {
            
            // Adiciona o controlador padrão
            require_once ABSPATH.'/controllers/home-controller.php';
            
            // Cria o objeto do controlador "home-controller.php"
            // Este controlador deverá ter uma classe chamada HomeController
            $this->controlador = new HomeController();
            
            //! Executa o método base() porque o método index é passado como abstrato
            //! para incrementar automaticamente header e footer em todas as paginas no mainController
            $this->controlador->base();
            
            return;
        }

        //* Se o ficheiro do controlador não existir, retorna com page 404
        if (!file_exists(ABSPATH.'/controllers/'.$this->controlador.'.php')) {
            // Página não encontrada
            require_once ERROR_PAGE;
            return;
        }

        //* Inclui o ficheiro do controlador
        require_once ABSPATH.'/controllers/'.$this->controlador.'.php';

        //* Remove caracteres inválidos do nome do controlador para gerar o nome
        //* da classe. Se o ficheiro chamar-se "news-controller.php", a classe deverá
        //* se chamar NewsController
        $this->controlador = preg_replace('/[^a-zA-Z]/i', '', $this->controlador);

        //* Se a classe do controlador indicado não existir, retorna com page 404
        if (!class_exists($this->controlador)) {
            require_once ERROR_PAGE;
            return;
        }

        //* Cria o objeto da classe do controlador e envia os parâmentros
        $this->controlador = new $this->controlador($this->parametros, $this->acao);

        //* Remove caracteres inválidos do nome da ação (método)
        $this->acao = preg_replace('/[^a-zA-Z]/i', '', $this->acao);

        //* Se o método indicado existir, executa o método e envia os parâmetros
        if (method_exists($this->controlador, $this->acao)) {
            $this->controlador->base();
            return;
        }
        
        // Página não encontrada
        require_once ERROR_PAGE;
        return;
    }

    private function get_url_data()
    {
        if (isset($_GET['path'])){

            $path = $_GET['path'];

            //* Limpa a string
            $path = rtrim($path, '/');
            $path = filter_var($path, FILTER_SANITIZE_HOME_URI);

            //* Cria um array de parâmetros
            $path = explode('/', $path);

            //* Configura as propriedades            
            $this->controlador = check($path, 0); // indice 0 do array, represetenta o controlador, por exemplo: projetos
            $this->controlador .= '-controller';

            $this->acao = check($path, 1); // indice 1 do array, representa a acção sobre o controlador, exemplo: add, rem

            //* Configura os parâmetros
            if (check($path, 2)) {
                unset($path[0]);
                unset($path[1]);

                // Os parâmetros sempre virão após a ação
                $this->parametros = array_values($path);
            }
        }

        if(isset($_GET['logout'])){
            session_destroy();
            header('Location: ./');
        }
    }
}