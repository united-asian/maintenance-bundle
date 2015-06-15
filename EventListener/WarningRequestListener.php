<?php
namespace UAM\Bundle\MaintenanceBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;

class WarningRequestListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {

    }
}