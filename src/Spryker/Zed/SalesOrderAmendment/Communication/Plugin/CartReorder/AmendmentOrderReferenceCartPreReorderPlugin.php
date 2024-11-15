<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Communication\Plugin\CartReorder;

use Generated\Shared\Transfer\CartReorderRequestTransfer;
use Generated\Shared\Transfer\CartReorderTransfer;
use Spryker\Zed\CartReorderExtension\Dependency\Plugin\CartPreReorderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\SalesOrderAmendment\Business\SalesOrderAmendmentFacadeInterface getFacade()
 * @method \Spryker\Zed\SalesOrderAmendment\SalesOrderAmendmentConfig getConfig()
 */
class AmendmentOrderReferenceCartPreReorderPlugin extends AbstractPlugin implements CartPreReorderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Expects `CartReorderRequestTransfer.isAmendment` to be set.
     * - Requires `CartReorderTransfer.quote` to be set.
     * - Requires `CartReorderRequestTransfer.orderReference` to be set.
     * - Does nothing if `CartReorderTransfer.quote.amendmentOrderReference` is already set.
     * - Sets `CartReorderTransfer.quote.amendmentOrderReference` taken from `CartReorderRequestTransfer.orderReference`.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CartReorderRequestTransfer $cartReorderRequestTransfer
     * @param \Generated\Shared\Transfer\CartReorderTransfer $cartReorderTransfer
     *
     * @return \Generated\Shared\Transfer\CartReorderTransfer
     */
    public function preReorder(
        CartReorderRequestTransfer $cartReorderRequestTransfer,
        CartReorderTransfer $cartReorderTransfer
    ): CartReorderTransfer {
        if ($cartReorderRequestTransfer->getIsAmendment() && !$cartReorderTransfer->getQuoteOrFail()->getAmendmentOrderReference()) {
            $cartReorderTransfer->getQuoteOrFail()->setAmendmentOrderReference(
                $cartReorderRequestTransfer->getOrderReferenceOrFail(),
            );
        }

        return $cartReorderTransfer;
    }
}