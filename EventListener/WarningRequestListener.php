<?php
namespace UAM\Bundle\MaintenanceBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use UAM\Bundle\MaintenanceBundle\Propel\MaintenanceQuery;

class WarningRequestListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        $current_date = date("Y/m/d");

        $maintenance = MaintenanceQuery::create()
            ->filterByDateStart(array('max' => $current_date ))
            ->orderByDateStart('desc')
            ->filterByConfirmed($confirmed = true)
            ->findOne();

        $date_start = $maintenance->getDateStart();
        $date_end = $maintenance->getDateEnd();

        if (($current_date >= $date_start ) && ($current_date <= $date_end))
        {
            $adminController = $this->get('admin.controller')->progress($array);
        }
        else{
        return;
        }
    }
}
