<?

class HomeController extends MainController
{
    public static $title = 'Home';
    public static $js = 'home';

    public function index()
    {
        $this->models[] = $this->load_model('home-model');

        $this->load_view("home");
    }
}