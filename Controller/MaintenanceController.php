<?php

namespace UAM\Bundle\MaintenanceBundle\Controller;

use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UAM\Bundle\DatatablesBundle\Controller\DatatablesEnabledControllerTrait;
use UAM\Bundle\MaintenanceBundle\Propel\Maintenance;
use UAM\Bundle\MaintenanceBundle\Propel\MaintenanceManager;
use UAM\Bundle\MaintenanceBundle\Propel\MaintenanceQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MaintenanceController extends Controller
{
    use DatatablesEnabledControllerTrait {
        indexAction as baseIndexAction;
        listAction as baseListAction;
    }

    /**
     * @Template()
     */
    public function warningAction(Request $request)
    {
        $current_date = new DateTime('now');

        $maintenance = MaintenanceQuery::create()
            ->filterByDateStart(array('min' => $current_date))
            ->orderByDateStart('asc')
            ->filterByConfirmed($confirmed = true)
            ->findOne();

        if ($maintenance) {
            $date_start = $maintenance->getDateStart();
            $date_end = $maintenance->getDateEnd();

            $warning_delay = $this->container->getParameter('uam_maintenance.warning_delay');
            
            $warning_delay_test = date_diff($date_start, $current_date, true);
            $warning_delay_test = $warning_delay_test->format('%R%a days');
            
            if($warning_delay_test <= $warning_delay) {
                $this->get('session')->getFlashBag()->add(
                    'alert',
                    $this->get('translator')->trans(
                        'maintenance.warning',
                        array('%date_start%' => $date_start->format('Y-M-d H:i:s'),'%date_end%' => $date_end->format('Y-M-d H:i:s')),
                        'UAMMaintenanceBundle',
                        $request->getLocale()
                    )
                );
            }
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
