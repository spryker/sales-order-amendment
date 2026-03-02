<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Business\Creator;

use Generated\Shared\Transfer\SalesOrderAmendmentRequestTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentResponseTransfer;

interface SalesOrderAmendmentCreatorInterface
{
    public function createSalesOrderAmendment(
        SalesOrderAmendmentRequestTransfer $salesOrderAmendmentRequestTransfer
    ): SalesOrderAmendmentResponseTransfer;
}
