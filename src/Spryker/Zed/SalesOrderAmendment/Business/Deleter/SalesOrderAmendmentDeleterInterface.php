<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Business\Deleter;

use Generated\Shared\Transfer\SalesOrderAmendmentDeleteCriteriaTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentResponseTransfer;

interface SalesOrderAmendmentDeleterInterface
{
    public function deleteSalesOrderAmendment(
        SalesOrderAmendmentDeleteCriteriaTransfer $salesOrderAmendmentDeleteCriteriaTransfer
    ): SalesOrderAmendmentResponseTransfer;
}
