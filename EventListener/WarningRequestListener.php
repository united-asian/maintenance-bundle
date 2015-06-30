<?php
namespace UAM\Bundle\MaintenanceBundle\EventListener;

use DateTime;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use UAM\Bundle\MaintenanceBundle\Propel\MaintenanceQuery;

class WarningRequestListener
{
    protected $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $current_date = new DateTime();

        $maintenance = MaintenanceQuery::create()
            ->filterByDateStart(array("max" => $current_date))
            ->filterByDateEnd(array("min" => $current_date))
            ->filterByConfirmed(true)
            ->findOne();

        
        if ($maintenance) {
            $route = 'uam_maintenance_progress';

            $request_url = $event->getRequest()->getUri();
            $url = $this->router->generate($route, array(), true);

            if ($request_url != $url) {
                $event->setResponse(new RedirectResponse($url));
            }
        }
    }
}
