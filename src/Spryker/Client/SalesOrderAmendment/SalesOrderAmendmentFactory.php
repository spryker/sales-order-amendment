<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\SalesOrderAmendment;

use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\SalesOrderAmendment\Checker\CurrentCurrencyIsoCodeChecker;
use Spryker\Client\SalesOrderAmendment\Checker\CurrentCurrencyIsoCodeCheckerInterface;
use Spryker\Client\SalesOrderAmendment\Checker\CurrentPriceModeChecker;
use Spryker\Client\SalesOrderAmendment\Checker\CurrentPriceModeCheckerInterface;
use Spryker\Client\SalesOrderAmendment\Dependency\Client\SalesOrderAmendmentToMessengerClientInterface;
use Spryker\Client\SalesOrderAmendment\Dependency\Client\SalesOrderAmendmentToQuoteClientInterface;

class SalesOrderAmendmentFactory extends AbstractFactory
{
    public function createCurrentCurrencyIsoCodeChecker(): CurrentCurrencyIsoCodeCheckerInterface
    {
        return new CurrentCurrencyIsoCodeChecker(
            $this->getQuoteClient(),
            $this->getMessengerClient(),
        );
    }

    public function createCurrentPriceModeChecker(): CurrentPriceModeCheckerInterface
    {
        return new CurrentPriceModeChecker($this->getMessengerClient());
    }

    public function getQuoteClient(): SalesOrderAmendmentToQuoteClientInterface
    {
        return $this->getProvidedDependency(SalesOrderAmendmentDependencyProvider::CLIENT_QUOTE);
    }

    public function getMessengerClient(): SalesOrderAmendmentToMessengerClientInterface
    {
        return $this->getProvidedDependency(SalesOrderAmendmentDependencyProvider::CLIENT_MESSENGER);
    }
}
