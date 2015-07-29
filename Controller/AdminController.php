<?php

namespace UAM\Bundle\MaintenanceBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UAM\Bundle\DatatablesBundle\Controller\DatatablesEnabledControllerTrait;
use UAM\Bundle\MaintenanceBundle\Propel\Maintenance;
use UAM\Bundle\MaintenanceBundle\Propel\MaintenanceManager;
use UAM\Bundle\MaintenanceBundle\UAMMaintenanceBundle;

/**
 * @Security("is_granted(UAMMaintenanceBundle::ROLE_UAM_MAINTENANCE)")
 */
class AdminController extends Controller
{
    use DatatablesEnabledControllerTrait {
        indexAction as baseIndexAction;
        listAction as baseListAction;
    }

    /**
     * @Route(
     *      "/maintenance",
     *      name="uam_maintenance_admin_index"
     * )
     *
     * @Template()
     */
    public function indexAction(Request $request)
    {
        return $this->baseIndexAction($request);
    }

   /**
    * @Route(
    *       "/maintenance/list",
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
     * @Route(
     *      "/maintenance/{id}",
     *      name="uam_maintenance_admin_show",
     *      requirements={
     *          "id": "\d+"
     *      }
     * )
     *
     * @Template()
     */
    public function showAction(Request $request, Maintenance $maintenance)
    {
        return array(
            'maintenance' => $maintenance
        );
    }

    /**
     * @inheritdoc
     */
    protected function getEntityManager()
    {
        return new MaintenanceManager();
    }
}
