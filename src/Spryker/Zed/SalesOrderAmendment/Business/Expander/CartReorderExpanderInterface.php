<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Business\Expander;

use Generated\Shared\Transfer\CartReorderRequestTransfer;
use Generated\Shared\Transfer\CartReorderTransfer;

interface CartReorderExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\CartReorderRequestTransfer $cartReorderRequestTransfer
     * @param \Generated\Shared\Transfer\CartReorderTransfer $cartReorderTransfer
     *
     * @return \Generated\Shared\Transfer\CartReorderTransfer
     */
    public function expandCartReorderWithOriginalSalesOrderItems(
        CartReorderRequestTransfer $cartReorderRequestTransfer,
        CartReorderTransfer $cartReorderTransfer
    ): CartReorderTransfer;
}
