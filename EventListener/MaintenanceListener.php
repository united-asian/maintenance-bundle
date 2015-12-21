<?php

namespace UAM\Bundle\MaintenanceBundle\EventListener;

use DateTime;
use Symfony\Bundle\AsseticBundle\Controller\AsseticController;
use Symfony\Bundle\WebProfilerBundle\Controller\ProfilerController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use UAM\Bundle\MaintenanceBundle\Controller\MaintenanceController;
use UAM\Bundle\MaintenanceBundle\Exceptions\AppUnderMaintenanceException;
use UAM\Bundle\MaintenanceBundle\Propel\MaintenanceQuery;

class MaintenanceListener
{
    protected $request_stack;

    public function __construct(RequestStack $request_stack)
    {
        $this->request_stack = $request_stack;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        die('maintenance');
        $request = $this->getCurrentRequest();

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

        var_dump($current_date->format('Y-m-d'));
        die();

        $maintenance = MaintenanceQuery::create()
            ->filterByDateStart(array("max" => $current_date))
            ->filterByDateEnd(array("min" => $current_date))
            ->filterByConfirmed(true)
            ->orderByDateStart('asc')
            ->findOne();

        if ($maintenance) {
            $maintenance->setLocale($request->getLocale());

            var_dump($maintenance);

            throw new AppUnderMaintenanceException($maintenance, 'App under maintenance', null, null);
        } else {

            $upcomming_maintenance = MaintenanceQuery::create()
                ->filterByDateStart(array('min' => $current_date))
                ->orderByDateStart('asc')
                ->filterByConfirmed(true)
                ->findOne();

            if ($upcomming_maintenance) {

                $session = $this->container->get('session');
                $translator = $this->container->get('translator');

                $session->getFlashBag()->set(
                    'maintenance',
                    $this->container->get('templating')->render(
                        ('UAMMaintenanceBundle:Maintenance:warning.html.twig'),
                        array(
                            'upcomming_maintenance' => $upcomming_maintenance,
                        )
                    )
                );
            }
        }

            die();
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

    protected function getRequestStack()
    {
        return $this->request_stack;
    }

    protected function getCurrentRequest()
    {
        return $this->getRequestStack()
            ->getCurrentRequest();
    }
}
