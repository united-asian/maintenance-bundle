<?php

namespace uam\UAMMaintenanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('UAMMaintenanceBundle:Default:index.html.twig', array('name' => $name));
    }
}
