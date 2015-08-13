<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\Banking\Account;

class AccountWasOpened
{
    /**
     * @var string
     */
    public $accountId;

    /**
     * @var string
     */
    public $startingBalance;

    public function __construct($accountId, $startingBalance)
    {
        $this->accountId = $accountId;
        $this->startingBalance = $startingBalance;
    }
}
