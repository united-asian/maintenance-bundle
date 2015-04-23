<?php
namespace MaintenanceBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/maintenance")
*/
class MaintenanceController extends Controller
{
/**
 * @Route("/")
*/
    public function indexAction(Request $request)
    {
        return array();
    }
}


