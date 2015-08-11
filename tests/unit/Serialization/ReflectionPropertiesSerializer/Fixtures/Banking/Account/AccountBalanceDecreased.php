<?php

namespace Monii\Serialization\ReflectionPropertiesSerializer\Fixtures\Banking\Account;

class AccountBalanceDecreased
{
    public $accountId;
    public $amount;
    public function __construct($accountId, $amount)
    {
        $this->accountId = $accountId;
        $this->amount = $amount;
    }
}
