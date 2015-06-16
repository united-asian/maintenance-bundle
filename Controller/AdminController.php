<?php

namespace UAM\Bundle\MaintenanceBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UAM\Bundle\DatatablesBundle\Controller\DatatablesEnabledControllerTrait;
use UAM\Bundle\MaintenanceBundle\Propel\MaintenanceManager;
use UAM\Bundle\MaintenanceBundle\Propel\Maintenance;
use UAM\Bundle\MaintenanceBundle\Propel\MaintenanceQuery;

class AdminController extends Controller
{
    use DatatablesEnabledControllerTrait {
        indexAction as baseIndexAction;
        listAction as baseListAction;
    }

    /**
     * @Route(
     *      "/",
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
     * @Route(
     *      "/{id}",
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
     * @Route(
     *      "/warning",
     *      name="uam_maintenance_admin_warning"
     * )
     *
     * @Template()
     */
    public function warningAction(Request $request )
    {
        $current_date = date("Y/m/d");

        $maintenance = MaintenanceQuery::create()
            ->filterByDateStart(array('min' => $current_date ))
            ->orderByDateStart('asc')
            ->filterByConfirmed($confirmed = true)
            ->findOne();

        if ($maintenance) {
            $date_start = $maintenance->getDateStart();
            $date_end = $maintenance->getDateEnd();

            $this->get('session')->getFlashBag()->add(
                'alert',
                $this->get('translator')->trans(
                    'maintenance.warning',
                    array('%date_start%' => $date_start->format('Y-M-d'),'%date_end%' => $date_end->format('Y-M-d')),
                    'maintenance',
                    $request->getLocale()
                )
            );
        }

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
