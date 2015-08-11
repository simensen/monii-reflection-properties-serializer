<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\Banking\Account;

class AccountWasOpened
{
    public $accountId;
    public $startingBalance;

    public function __construct($accountId, $startingBalance)
    {
        $this->accountId = $accountId;
        $this->startingBalance = $startingBalance;
    }
}
