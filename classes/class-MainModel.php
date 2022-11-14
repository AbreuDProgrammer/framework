<?

abstract class MainModel
{
    private $form_data;
    private $form_msg;
    private $form_confirma;

    private $db;
    
    private $parametros;
    private $login;

    public function __construct($parametros = null)
    {
        // Configura o DB (PDO)
        $this->db = SystemDB::getInstance();

        // Configura os parâmetros
        $this->parametros = $parametros;

        // Configura os dados do user
        $this->login = Login::getInstance();

        // Executa a funcao "contruct" dos models
        $this->onCreate();
    }

    protected abstract function onCreate();

    protected function getSites()
    {
        $query = $this->db->query("SELECT * FROM `sites` WHERE 1");
        $query = $query->fetchAll(PDO::FETCH_ASSOC);
        return $query;
    }
}