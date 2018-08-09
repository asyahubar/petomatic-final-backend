<?php

namespace Petomatic\Controllers;
use Petomatic\Core\Application;

class VisitsController
{
    public function getvisittypes()
    {
        $visittypes = Application::get('database')->getVisitTypes();
        echo json_encode($visittypes);
    }

    public function addvisit()
    {
        $d = trim(file_get_contents("php://input"));
        $credentials = json_decode($d, true);

        $newVisit = Application::get('database')->addVisit($credentials);
        echo $newVisit;
    }

    public function getvisitstoday()
    {
        $todaysVisits = Application::get('database')->todaysVisits();
        echo json_encode($todaysVisits);
    }

    public function editvisit()
    {
        
    }
}