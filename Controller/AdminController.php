<?php

namespace UAM\Bundle\MaintenanceBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UAM\Bundle\DatatablesBundle\Controller\DatatablesEnabledControllerTrait;
use UAM\Bundle\MaintenanceBundle\Form\Type\MaintenanceFormType;
use UAM\Bundle\MaintenanceBundle\Propel\Maintenance;
use UAM\Bundle\MaintenanceBundle\Propel\MaintenanceManager;

/**
 * @Template()
 * @Security("is_granted('ROLE_UAM_MAINTENANCE_ADMIN')")
 */
class AdminController extends Controller
{
    use DatatablesEnabledControllerTrait {
        indexAction as baseIndexAction;
        listAction as baseListAction;
    }

    public function indexAction(Request $request)
    {
        return $this->baseIndexAction($request);
    }

    public function listAction(Request $request)
    {
        return $this->baseListAction($request);
    }

    public function createAction(Request $request)
    {
        $maintenance = new Maintenance();

        $form = $this->createForm(
            new MaintenanceFormType(),
            $maintenance
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $maintenance->save();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('create.success', array(), 'maintenance', $request->getLocale())
            );

            return $this->redirect($this->generateUrl('uam_maintenance_admin_index'));
        }

        return array(
            'maintenance' => $maintenance,
            'form' => $form->createView()
        );
    }

    public function editAction(Request $request, Maintenance $maintenance)
    {
        $form = $this->createForm(
            new MaintenanceFormType(),
            $maintenance
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $maintenance->save();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('edit.success', array(), 'maintenance', $request->getLocale())
            );

            return $this->redirect($this->generateUrl('uam_maintenance_admin_index'));
        }

        return array(
            'maintenance' => $maintenance,
            'form' => $form->createView()
        );
    }

    public function deleteAction(Request $request, Maintenance $maintenance)
    {
        return $this->redirect($this->generateUrl('uam_maintenance_admin_index'));
    }

    /**
     * @inheritdoc
     */
    protected function getEntityManager()
    {
        return new MaintenanceManager();
    }
}
