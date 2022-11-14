<?
	/*
	* http://php.net/manual/pt_BR/function.autoload.php.
	* Classes estão na pasta classes.
	* O nome do ficheiro deverá ser class-NomeDaClasse.php.
	* Por exemplo: para a classe System, o ficheiro chamar-se class-System.php
	*/
    
	function leo_autoloader($class_name) {
		$file = ABSPATH.'/classes/class-'.$class_name.'.php';
		if (!file_exists($file)) {
            echo $file;
			require_once ERROR_PAGE;
			return;
		}
		// inclui o ficheiro da classe
		require_once $file;
	}
	spl_autoload_register('leo_autoloader');

    // Splice
    function cut($array, $length, $fromStart = true)
    {
        if($fromStart){
            $length--;
            foreach($array as $key => $value){
                if($key <= $length){
                    unset($array[$key]);
                }
            }
        } else {
            $length = count($array) - $length;
            foreach($array as $key => $value){
                if($key >= $length){
                    unset($array[$key]);
                }
            }
        }
        return $array;
    }

    // chk_array
    function check($array, $key = null)
    {
        if(isset($array[$key]) && !empty($array[$key]))
            return $array[$key];
        else
            return null;
    }

?>
