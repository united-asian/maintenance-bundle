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
     * @Route(
     *      "/warning",
     *      name="uam_maintenance_warning"
     * )
     *
     * @Template()
     */
    public function warningAction(Request $request)
    {
        $current_date = new DateTime('now');
        $current_date = $current_date->format('Y-m-d H:m:s');

        $maintenance = MaintenanceQuery::create('Maintenance')
            ->where("Maintenance.date_start>'$current_date'")
            ->filterByConfirmed(true)
            ->findOne();

        if ($maintenance) {
            $date_start = $maintenance->getDateStart();
            $date_end = $maintenance->getDateEnd();

            $this->get('session')->getFlashBag()->add(
                'alert',
                $this->get('translator')->trans(
                    'maintenance.warning',
                    array('%date_start%' => $date_start->format('Y-M-d H:i:s'),'%date_end%' => $date_end->format('Y-M-d H:i:s')),
                    'maintenance',
                    $request->getLocale()
                )
            );
        }

        return array();
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
