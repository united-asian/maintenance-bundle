<?php

namespace UAM\Bundle\MaintenanceBundle\EventListener;

use DateTime;
use Symfony\Bundle\AsseticBundle\Controller\AsseticController;
use Symfony\Bundle\WebProfilerBundle\Controller\ProfilerController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Routing\RouterInterface;
use UAM\Bundle\MaintenanceBundle\Controller\MaintenanceController;
use UAM\Bundle\MaintenanceBundle\Exceptions\AppUnderMaintenanceException;
use UAM\Bundle\MaintenanceBundle\Propel\MaintenanceQuery;

class MaintenanceListener
{
    protected $router, $container;

    public function __construct(RouterInterface $router, ContainerInterface $container)
    {
        $this->router = $router;
        $this->container = $container;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof AsseticController ||
            $controller[0] instanceof ProfilerController ||
            $controller[0] instanceof MaintenanceController) {
            return;
        }

        $current_date = new DateTime();

        $maintenance = MaintenanceQuery::create()
            ->filterByDateStart(array("max" => $current_date))
            ->filterByDateEnd(array("min" => $current_date))
            ->filterByConfirmed(true)
            ->orderByDateStart('asc')
            ->findOne();

        if ($maintenance) {
            throw new AppUnderMaintenanceException($maintenance, 'App under maintenance',null, null);
        }
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!($exception instanceof AppUnderMaintenanceException)) {
            return;
        }

        $response = new Response(
            $this->container->get('templating')->render(
                ('UAMMaintenanceBundle:Maintenance:progress.html.twig'),
                array(
                    'maintenance' => $exception->getMaintenance(),
                )
            )
        );

        $event->setResponse($response);
    }
}
