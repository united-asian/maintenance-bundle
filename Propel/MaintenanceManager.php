<?php

namespace UAM\Bundle\MaintenanceBundle\Propel;

use Model\UAMMaintenanceQuery;
use Symfony\Component\HttpFoundation\Request;
use UAM\Bundle\DatatablesBundle\Propel\AbstractEntityManager;

class EntityManager extends AbstractEntityManager
{
    /**
     * @inheritdoc
     */
    protected function getQuery(Request $request)
    {
        return UAMMaintenanceQuery::create('Member');
    }

    /**
     * @inheritdoc
     */
    protected function getSearchColumns(Request $request)
    {
        return array();
    }

    /**
     * @inheritdoc
     */
    protected function getSortColumns(Request $request)
    {
        return array();
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultSortOrder(Request $request)
    {
        return array();
    }
}