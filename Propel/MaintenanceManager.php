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
            ->joinI18n($request->getLocale());
    }

    /**
     * @inheritdoc
     */
    protected function getSearchColumns(Request $request)
    {
        return array(
            'id' => 'uam_maintenance.id LIKE "%d"',
            'description' => 'uam_maintenance_i18n.description LIKE "%%%s%%"'
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
