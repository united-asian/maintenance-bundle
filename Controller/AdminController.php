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

    public function showAction(Request $request, $id)
    {
        $manager = $this->getEntityManager();

        $maintenance = $manager
            ->getQuery($request)
            ->filterById($id)
            ->findOne();

        if (!$maintenance) {
            throw $this->createNotFoundException(sprintf(
                'Unable to find a Maintenence for id: %d',
                $id
            ));
        }

        return array(
            'maintenance' => $maintenance
        );
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
                $this->get('translator')->trans('maintenance.create.success', array(), 'maintenance', $request->getLocale())
            );

            return $this->redirect($this->generateUrl('uam_maintenance_admin_index'));
        }

        return array(
            'maintenance' => $maintenance,
            'form' => $form->createView()
        );
    }

    /**
     * @inheritdoc
     */
    protected function getEntityManager()
    {
        return new MaintenanceManager();
    }
}
