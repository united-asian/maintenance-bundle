<?php

namespace UAM\Bundle\MaintenanceBundle\Propel;

use UAM\Bundle\MaintenanceBundle\Propel\MaintenanceQuery;
use Symfony\Component\HttpFoundation\Request;
use UAM\Bundle\DatatablesBundle\Propel\AbstractEntityManager;

class MaintenanceManager extends AbstractEntityManager
{
    /**
     * @inheritdoc
     */
    protected function getQuery(Request $request)
    {
        return MaintenanceQuery::create()
            ->useMaintenanceI18nQuery('maintenanceI18n')
                ->filterByLocale($request->getLocale())
            ->endUse();
    }

    /**
     * @inheritdoc
     */
    protected function getSearchColumns(Request $request)
    {
        return array(
            'id' => 'uam_maintenance.id LIKE "%d"',
            'description' => 'maintenanceI18n.Description LIKE "%%%s%%"'
        );
    }

    /**
     * @inheritdoc
     */
    protected function getSortColumns(Request $request)
    {
        return array(
            1 => 'uam_maintenance.Id',
            2 => 'uam_maintenance.DateStart',
            3 => 'uam_maintenance.DateEnd',
            4 => 'maintenanceI18n.Description',
            5 => 'uam_maintenance.Confirmed'
        );
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultSortOrder(Request $request)
    {
        return array(
        array('uam_maintenance.DateStart', 'asc')
        );
    }
}
