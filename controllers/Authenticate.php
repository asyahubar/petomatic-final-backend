<?php
 
namespace Petomatic\Controllers;
use \Petomatic\Core\Application;

class Authenticate {

    private function hash($credentials)
    {
        $password = $credentials;
        $password = crypt($password, '$1$yammy$');
        return $password;
    }

    public function validate()
    {
        $d = trim(file_get_contents("php://input"));
        $credentials = json_decode($d, true);
        $doctor = Application::get('database')->getOneUser($credentials['email']);
        if(!$doctor){
            echo false;
        }
        $password = $this->hash($credentials['pass']);
        if ($password === $doctor->password) {
            $_SESSION['auth'] = $doctor;
            echo true;
        } else {
            echo false;
        }
    }

    public function logout()
    {
        unset($_SESSION["auth"]);
        return redirect('/');
    }

}