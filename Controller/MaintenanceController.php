<?php

namespace UAM\Bundle\MaintenanceBundle\Controller;

use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UAM\Bundle\MaintenanceBundle\Propel\MaintenanceQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MaintenanceController extends Controller
{
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
     * @Route(
     *      "/progress",
     *      name="uam_maintenance_progress"
     * )
     *
     * @Template()
     */
    public function progressAction(Request $request)
    {
        $current_date = new DateTime();

        $maintenance = MaintenanceQuery::create()
            ->filterByDateStart(array('max' => $current_date))
            ->orderByDateStart('desc')
            ->filterByConfirmed($confirmed = true)
            ->findOne();

        $maintenance->setLocale($request->getLocale());

        $description = $maintenance->getDescription();
        $date_end = $maintenance->getDateEnd();

        $this->get('session')->getFlashBag()->add(
            'alert',
            $this->get('translator')->trans(
                'maintenance.progress',
                array('%description%' => $description,'%date_end%' => $date_end->format('Y-M-d H:i:s')),
                'UAMMaintenanceBundle',
                $request->getLocale()
            )
        );

        return array(
            'maintenance' => $maintenance
        );
    }
}
