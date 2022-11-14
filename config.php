<?

// Caminho para a raiz
define('ABSPATH', dirname(__FILE__));

// Caminho para a pasta de uploads
define('UP_ABSPATH', ABSPATH . '/views/_uploads');

// HOME_URI da home
define('HOME_URI','http://localhost/main_site/');

// Nome do host da base de dados
define('HOSTNAME', 'alunos.epcc.pt');

// Nome do DB
define('DB_NAME', 'al220038_main');

// User do DB
define('DB_USER', 'al220038');

// Pass do DB
define('DB_PASSWORD', 'epcc2020');

// Charset da conexão PDO
define('DB_CHARSET', 'utf8');

// Programador, modifique o valor para true
define('DEBUG', true);

// Pagina de erro
define('ERROR_PAGE', ABSPATH.'/views/_includes/404.php');

// Carrega o loader, que vai carregar a aplicação inteira
require_once ABSPATH . '/loader.php';