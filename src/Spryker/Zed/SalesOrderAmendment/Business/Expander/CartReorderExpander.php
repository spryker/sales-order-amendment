<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Business\Expander;

use Generated\Shared\Transfer\CartReorderRequestTransfer;
use Generated\Shared\Transfer\CartReorderTransfer;
use Generated\Shared\Transfer\OriginalSalesOrderItemTransfer;
use Spryker\Service\SalesOrderAmendment\SalesOrderAmendmentServiceInterface;

class CartReorderExpander implements CartReorderExpanderInterface
{
    public function __construct(protected SalesOrderAmendmentServiceInterface $salesOrderAmendmentService)
    {
    }

    public function expandCartReorderWithOriginalSalesOrderItems(
        CartReorderRequestTransfer $cartReorderRequestTransfer,
        CartReorderTransfer $cartReorderTransfer
    ): CartReorderTransfer {
        if (!$cartReorderRequestTransfer->getIsAmendment()) {
            return $cartReorderTransfer;
        }

        foreach ($cartReorderTransfer->getOrderOrFail()->getItems() as $itemTransfer) {
            $cartReorderTransfer->getQuoteOrFail()->addOriginalSalesOrderItem(
                (new OriginalSalesOrderItemTransfer())
                    ->fromArray($itemTransfer->toArray(), true)
                    ->setGroupKey(
                        $this->salesOrderAmendmentService->buildOriginalSalesOrderItemGroupKey($itemTransfer),
                    ),
            );
        }

        return $cartReorderTransfer;
    }
}
