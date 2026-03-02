<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Business\Hydrator;

use Generated\Shared\Transfer\CartReorderTransfer;

interface CartReorderItemHydratorInterface
{
    public function hydrateOriginalSalesOrderItemGroupKeys(
        CartReorderTransfer $cartReorderTransfer
    ): CartReorderTransfer;
}
