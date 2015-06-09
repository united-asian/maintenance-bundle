<?php

namespace UAM\Bundle\MaintenanceBundle\Entitymanager;

use UAM\Bundle\MaintenanceBundle\Propel\UAMMaintenanceQuery;
use Symfony\Component\HttpFoundation\Request;
use UAM\Bundle\DatatablesBundle\Propel\AbstractEntityManager;

class MaintenanceManager extends AbstractEntityManager
{
	/**
	 * @inheritdoc
	 */
	protected function getQuery(Request $request)
	{
		return UAMMaintenanceQuery::create('Maintenance');
	}

	/**
	 * @inheritdoc
	 */
	protected function getSearchColumns(Request $request)
	{
		return array(
            'id' => 'Maintenance.id LIKE "%d"'
        );
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
