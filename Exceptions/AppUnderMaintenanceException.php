<?php

namespace UAM\Bundle\MaintenanceBundle\Exceptions;

use UAM\Bundle\MaintenanceBundle\Propel\Maintenance;
use RuntimeException;

class AppUnderMaintenanceException extends RuntimeException
{
    protected $maintenance;

    public function __construct(Maintenance $maintenance, $message, $code, $previous)
    {
        $this->maintenance = $maintenance;

        parent::__construct($message, $code, $previous);
    }

    public function getMaintenance()
    {
        return $this->maintenance;
    }
}
