<?php

namespace Petomatic\Controllers;
use \Petomatic\Core\Application;
use \Petomatic\Core\Request;

class OwnersController
{
    public function getowners()
    {
        $owners = Application::get('database')->getOwners();
        echo json_encode($owners);
    }

    public function getpetsbyowner()
    {
        $uri = Request::prepare();
        $uriParts = explode('/', $uri);
        $id = $uriParts[2];
        $pets = Application::get('database')->getPetsByOwner($id);
        echo json_encode($pets);
    }
}