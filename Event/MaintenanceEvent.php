<?php

namespace UAM\Bundle\MaintenanceBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use UAM\Bundle\MaintenanceBundle\Propel\Maintenance;

class MaintenanceEvent extends Event
{
    protected $maintenance;

    public function __construct(Maintenance $maintenance)
    {
        $this->task = $maintenance;
    }

    public function getMaintenance()
    {
        return $this->task;
    }
}
