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

        $maintenance = MaintenanceQuery::create('Maintenance')
            ->filterByDateStart(array('min' => $current_date))
            ->orderByDateStart('asc')
            ->filterByConfirmed(true)
            ->findOne();

        if ($maintenance) {

            return array(
                'maintenance' => $maintenance
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
            ->filterByDateStart(array("max" => $current_date))
            ->filterByDateEnd(array("min" => $current_date))
            ->filterByConfirmed(true)
            ->orderByDateStart('asc')
            ->findOne();

        if ($maintenance) {
            $maintenance->setLocale($request->getLocale());

            return array(
                'maintenance' => $maintenance
            );
        }

        return array();
    }
}
