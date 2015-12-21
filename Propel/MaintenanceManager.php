<?php

namespace UAM\Bundle\MaintenanceBundle\Propel;

use Symfony\Component\HttpFoundation\Request;
use UAM\Bundle\DatatablesBundle\Propel\AbstractEntityManager;
use UAM\Bundle\MaintenanceBundle\Filter\Type\MaintenenceFilterType;

class MaintenanceManager extends AbstractEntityManager
{
    /**
     * {@inheritdoc}
     */
    public function getQuery(Request $request)
    {
        return MaintenanceQuery::create()
            ->joinI18n($request->getLocale());
    }

    /**
     * {@inheritdoc}
     */
    protected function getSearchColumns(Request $request)
    {
        return array(
            'date' => 'uam_maintenance.date_start <= "%1$s" AND uam_maintenance.date_end >= "%1$s"',
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getSortColumns(Request $request)
    {
        return array(
            1 => 'uam_maintenance.Id',
            2 => 'uam_maintenance.DateStart',
            3 => 'uam_maintenance.DateEnd',
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultSortOrder(Request $request)
    {
        return array(
        array('uam_maintenance.DateStart', 'asc'),
        );
    }

    public function getFilterType(Request $request)
    {
        return new MaintenenceFilterType();
    }
}
