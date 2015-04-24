<?php
namespace UAM\Bundle\MaintenanceBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Model\UAMMaintenanceQuery;

/**
 * @Route("/maintenance")
*/
class MaintenanceController extends Controller
{
    /**
     * @Route("/")
    */
    public function indexAction(Request $request)
    {
        return array();
    }
    /**
     * @Route("/list", name="maintenance_record_list", requirements={"_format": "json"}, defaults={"_format": "json"})
     * @Template()
    */
    public function listAction(Request $request)
    {
        $query = $this->getQuery();

        $total_count = $query
            ->count();

        $query->filter(
            $this->getFilters($request),
            $this->getSearchColumns()
        );

        $filtered_count = $query
            ->count();

        $limit = $this->getLimit($request);
        $offset = $this->getOffset($request);

        $persons = $query
            ->sort($this->getSortOrder($request))
            ->setLimit($limit)
            ->setOffset($offset)
            ->find();

        return array(
            'total_count' => $total_count,
            'filtered_count' => $filtered_count,
            'maintenance_records' => $maintenance_records
        );
    }

    protected function getQuery()
    {
        return UAMManitenanceQuery::create();
    }

    protected function getLimit(Request $request)
    {
        return min(100, $request->query->get('length', 10));
    }

    protected function getLimit(Request $request)
    {
        return min(100, $request->query->get('length', 10));
    }

    protected function getOffset(Request $request)
    {
        return max($request->query->get('start', 0), 0);
    }

    protected function getFilters(Request $request)
    {
        return array();
    }

    protected function getSearchColumns()
    {
        return array();
    }

    protected function getSortOrder(Request $request)
    {
        return array();
    }

    protected function getSortColumns()
    {
        return array();
    }
    /**
     * @Route("/{id}", name="maintenance_record_edit")
     * @Template()
    */
    public function editAction(Request $request, $id)
    {
        return array();
    }
}
