<?php

namespace UAM\Bundle\MaintenanceBundle\Propel;

use UAM\Bundle\MaintenanceBundle\Model\UAMMaintenanceQuery;
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
