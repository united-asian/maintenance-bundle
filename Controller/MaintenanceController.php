<?php
namespace UAM\Bundle\MaintenanceBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UAM\Bundle\DatatablesBundle\Controller\DatatablesEnabledControllerTrait;
use UAM\Bundle\MaintenanceBundle\Entitymanager\MaintenanceManager;
use UAM\Bundle\MaintenanceBundle\Propel\UAMMaintenance;
use UAM\Bundle\MaintenanceBundle\Propel\UAMMaintenanceQuery;

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
    public function showAction(Request $request, UAMMaintenance $maintenance)
    {
        return array(
            'maintenance' => $maintenance
        );
    }

    /**
     * @Route("/warning")
     * @Template()
     */
    public function warningAction(Request $request )
    {
        $current_date = date("Y/m/d");

        $maintenance = UAMMaintenanceQuery::create()
            ->filterByDateStart(array('min' => $current_date ))
            ->filterByConfirmed($confirmed = true)
            ->orderByDateStart('asc')
            ->findOne();

        $date_start = $maintenance->getDateStart();
        $date_end = $maintenance->getDateEnd();

        if ($maintenance) {
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

        return array('maintenance' => $maintenance);
    }

    /**
     * @inheritdoc
     */
    protected function getEntityManager()
    {
        return new MaintenanceManager();
    }
}
