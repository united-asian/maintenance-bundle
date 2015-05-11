<?php
namespace UAM\Bundle\MaintenanceBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UAM\Bundle\DatatablesBundle\Controller\DatatablesEnabledControllerTrait;

/**
 * @Route("/maintenance")
*/
class MaintenanceController extends Controller
{
    use DatatablesEnabledControllerTrait {
        indexAction as baseIndexAction;
    }
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        return array();
    }

    protected function getEntityManager()
    {

    }

}
