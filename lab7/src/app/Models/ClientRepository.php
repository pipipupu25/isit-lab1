<?php

namespace App\Models;

class ClientRepository extends JsonRepository
{
    public function __construct()
    {
        parent::__construct('clients.json');
    }
}
