<?php

namespace UAM\Bundle\MaintenanceBundle\Controller;

use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UAM\Bundle\MaintenanceBundle\Propel\MaintenanceQuery;

class MaintenanceController extends Controller
{
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
            ->filterByDateEnd(array('min' => $current_date))
            ->filterByConfirmed(true)
            ->orderByDateStart('asc')
            ->findOne();

        if ($maintenance) {
            $maintenance->setLocale($request->getLocale());

            return array(
                'maintenance' => $maintenance,
            );
        }

        return array();
    }
}
