<?php

namespace App\Models;

class ExecutorRepository extends JsonRepository
{
    public function __construct()
    {
        parent::__construct('executors.json');
    }
}
