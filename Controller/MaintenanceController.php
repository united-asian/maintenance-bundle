<?php
namespace UAM\Bundle\MaintenanceBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UAM\Bundle\DatatablesBundle\Controller\DatatablesEnabledControllerTrait;
use Model\UAMMaintenanceQuery;
use UAM\Bundle\MaintenanceBundle\Propel\MaintenanceManager;

/**
 * @Route("/maintenance", name="maintenance_record")
*/
class MaintenanceController extends Controller
{
    use DatatablesEnabledControllerTrait {
        indexAction as baseIndexAction;
        listAction as baseListAction;
    }
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        return $this->baseIndexAction($request);
    }

    /**
    * @Route("/list", name="maintenance_list")
    */
       public function listAction(Request $request)
    {
        return $this->baseListAction($request);
    }

    protected function getEntityManager()
    {

    }
}