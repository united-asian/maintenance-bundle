<?php

namespace Model;

use Model\om\BaseUAMMaintenanceQuery;

class UAMMaintenanceQuery extends BaseUAMMaintenanceQuery
{

    public function filter(array $filters = null, array $columns = array())
    {
        return $this;
    }

    public function sort(array $order = array())
    {
        return $this;
    }
}
