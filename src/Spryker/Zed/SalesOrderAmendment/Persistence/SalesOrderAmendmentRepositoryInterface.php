<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Persistence;

use Generated\Shared\Transfer\SalesOrderAmendmentCollectionTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentCriteriaTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentDeleteCriteriaTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentQuoteCollectionTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentQuoteCriteriaTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentTransfer;

interface SalesOrderAmendmentRepositoryInterface
{
    public function getSalesOrderAmendmentCollection(
        SalesOrderAmendmentCriteriaTransfer $salesOrderAmendmentCriteriaTransfer
    ): SalesOrderAmendmentCollectionTransfer;

    public function findSalesOrderAmendmentByDeleteCriteria(
        SalesOrderAmendmentDeleteCriteriaTransfer $salesOrderAmendmentDeleteCriteriaTransfer
    ): ?SalesOrderAmendmentTransfer;

    public function getSalesOrderAmendmentQuoteCollection(
        SalesOrderAmendmentQuoteCriteriaTransfer $salesOrderAmendmentQuoteCriteriaTransfer
    ): SalesOrderAmendmentQuoteCollectionTransfer;
}
