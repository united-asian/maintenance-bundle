<?php
namespace UAM\Bundle\MaintenanceBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UAM\Bundle\DatatablesBundle\Controller\DatatablesEnabledControllerTrait;
use UAM\Bundle\MaintenanceBundle\Propel\UAMMaintenanceQuery;
use UAM\Bundle\MaintenanceBundle\Entitymanager\MaintenanceManager;

/**
 * @Route("/maintenance", name="uam_maintenance_admin")
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
    * @Route(
    *       "/list",
    *       name="uam_maintenance_admin_list",
    *       requirements={
    *           "_format": "json"
    *       },
    *       defaults={
    *           "_format": "json"
    *       }
    * )
    *
    * @Template()
    */
    public function listAction(Request $request)
    {
        return $this->baseListAction($request);
    }

    /**
     * @inheritdoc
     */
    protected function getEntityManager()
    {
        return new MaintenanceManager();
    }
}
