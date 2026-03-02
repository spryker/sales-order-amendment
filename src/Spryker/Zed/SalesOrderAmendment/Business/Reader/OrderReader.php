<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Business\Reader;

use Generated\Shared\Transfer\OrderFilterTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Sales\Business\Exception\InvalidSalesOrderException;
use Spryker\Zed\SalesOrderAmendment\Dependency\Facade\SalesOrderAmendmentToSalesFacadeInterface;

class OrderReader implements OrderReaderInterface
{
    public function __construct(protected SalesOrderAmendmentToSalesFacadeInterface $salesFacade)
    {
    }

    public function findCustomerOrder(string $orderReference, string $customerReference): ?OrderTransfer
    {
        $orderFilterTransfer = (new OrderFilterTransfer())
            ->setOrderReference($orderReference)
            ->setCustomerReference($customerReference)
            ->setWithUniqueProductCount(false);

        try {
            return $this->salesFacade->getOrder($orderFilterTransfer);
        } catch (InvalidSalesOrderException $e) {
            return null;
        }
    }
}
