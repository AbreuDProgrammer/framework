<?

class HomeModel extends MainModel
{
    public $sites = array();
    
    protected function onCreate(){
        $sites = $this->getSites();
        foreach($sites as $site){
            $this->sites[] = Site::getInstance($site);
        }
    }
}