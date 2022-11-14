<?php
    /*
     * Server request php will manage the post and get requests
     * using functions to connect to the DB and answering with
     * echo json_encode() if success or null if it fail
     */

     if(!isset($_POST)){
         return;
     }

     class FunctionsList
     {
         function login($arguments)
         {
             $userdata = $arguments['userdata'];
             $query = "SELECT * FROM users WHERE username = '".$userdata['username']."'";

             // Verifica o username
             $fetch = query($query, 'fetch');
             if(!$fetch){
                 echo 'null';
                 return;
             }

             // Encripta a password
             $userdata['password'] = md5($userdata['password']);

             // Valida as duas
             if($userdata['password'] !== $fetch['password']){
                 echo 'password';
                 return;
             }

             // Cria um novo session id
             $oneHash = date("l jS \of F Y h:i:s A");
             $twoHash = $fetch['username'];
             $session = md5($oneHash.$twoHash);

             setSession($session, $userdata['username']);

             // Retira a password
             unset($fetch['password']);

             // Coloca a nova sessão
             $fetch['session_id'] = $session;

             echo json_encode($fetch);
         }
         function listSites()
         {
             $fetch = query("SELECT * FROM sites", 'fetchAll');
             if(!$fetch){
                 echo 'null';
                 return;
             }
             echo json_encode($fetch);
         }
         function getSite($arguments)
         {
             // separa o id
             $id = $arguments['id'];

            if(!$id)
                return;

             $fetch = query("SELECT * FROM sites WHERE id = '$id'", 'fetch');
             if(!$fetch){
                 echo 'null';
                 return;
             }

             echo json_encode($fetch);
         }
         function criarSite($arguments)
         {
             $name = $arguments['name'];
             $description = $arguments['description'];
             $link = $arguments['link'];
             $query = "INSERT INTO sites VALUES (NULL, '".$name."', '".$description."', '".$link."')";
             $fetch = query($query);
             if(!$fetch){
                 echo 'null';
                 return;
             }
             echo 'success';
         }
         function editarSite($arguments)
         {
             $id = $arguments['id'];
             $name = $arguments['name'];
             $description = $arguments['description'];
             $link = $arguments['link'];
             $query = "UPDATE sites SET id = '$id', name = '$name', description =  '$description', link = '$link' WHERE id = '$id';";
             $fetch = query($query);
             if(!$fetch){
                 echo 'null';
                 return;
             }
             echo 'success';
         }
         function deleteSite($arguments)
         {
             $id = $arguments['id'];
             $query = "DELETE FROM sites WHERE id = '$id';";
             $fetch = query($query);
             if(!$fetch){
                 echo 'null';
                 return;
             }
             echo 'success';
         }
     }

     $fl = new FunctionsList();

     $function = $_POST['function'];

     $fl->{$function}($_POST['arguments']);

     function query($query, $typeFetch = null)
     {
         $mysqli = new mysqli("alunos.epcc.pt", "al220038", "epcc2020", "al220038_main");
         $query = $mysqli->query($query);
         if(!$query){
             return;
         }
         if($typeFetch === 'fetchAll')
            $fetch = $query->fetch_all(MYSQLI_ASSOC);
        else if ($typeFetch === 'fetch')
            $fetch = $query->fetch_assoc();
        else
            $fetch = $query;
         return $fetch;
     }

     function setSession($session_id, $username)
     {
         $mysqli = new mysqli("alunos.epcc.pt", "al220038", "epcc2020", "al220038_main");
         $query = $mysqli->query("UPDATE users SET session_id = '$session_id' WHERE username = '$username'");
         return;
     }
?>
