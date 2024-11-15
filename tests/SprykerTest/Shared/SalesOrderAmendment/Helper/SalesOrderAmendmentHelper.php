<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Shared\SalesOrderAmendment\Helper;

use Codeception\Module;
use Generated\Shared\DataBuilder\SalesOrderAmendmentBuilder;
use Generated\Shared\Transfer\SalesOrderAmendmentTransfer;
use Orm\Zed\SalesOrderAmendment\Persistence\SpySalesOrderAmendment;
use SprykerTest\Shared\Testify\Helper\DataCleanupHelperTrait;

class SalesOrderAmendmentHelper extends Module
{
    use DataCleanupHelperTrait;

    /**
     * @param array<string, mixed> $seedData
     *
     * @return \Generated\Shared\Transfer\SalesOrderAmendmentTransfer
     */
    public function haveSalesOrderAmendment(array $seedData = []): SalesOrderAmendmentTransfer
    {
        $salesOrderAmendmentTransfer = (new SalesOrderAmendmentBuilder($seedData))->build();

        $salesOrderAmendmentEntity = new SpySalesOrderAmendment();
        $salesOrderAmendmentEntity->fromArray($salesOrderAmendmentTransfer->toArray());
        $salesOrderAmendmentEntity->save();

        $this->getDataCleanupHelper()->addCleanup(function () use ($salesOrderAmendmentEntity): void {
            $salesOrderAmendmentEntity->delete();
        });

        return $salesOrderAmendmentTransfer->fromArray($salesOrderAmendmentEntity->toArray(), true);
    }
}