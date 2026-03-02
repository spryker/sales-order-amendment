<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Business\Strategy;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentItemCollectionTransfer;

interface SalesOrderAmendmentItemCollectorStrategyInterface
{
    public function collect(
        QuoteTransfer $quoteTransfer,
        OrderTransfer $orderTransfer
    ): SalesOrderAmendmentItemCollectionTransfer;
}
