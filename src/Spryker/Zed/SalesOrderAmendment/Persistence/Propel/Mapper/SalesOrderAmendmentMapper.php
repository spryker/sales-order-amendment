<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\SalesOrderAmendmentCollectionTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentTransfer;
use Orm\Zed\SalesOrderAmendment\Persistence\SpySalesOrderAmendment;
use Propel\Runtime\Collection\ObjectCollection;

class SalesOrderAmendmentMapper
{
    public function mapSalesOrderAmendmentTransferToSalesOrderAmendmentEntity(
        SalesOrderAmendmentTransfer $salesOrderAmendmentTransfer,
        SpySalesOrderAmendment $salesOrderAmendmentEntity
    ): SpySalesOrderAmendment {
        return $salesOrderAmendmentEntity->fromArray($salesOrderAmendmentTransfer->modifiedToArray());
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\SalesOrderAmendment\Persistence\SpySalesOrderAmendment> $salesOrderAmendmentEntities
     * @param \Generated\Shared\Transfer\SalesOrderAmendmentCollectionTransfer $salesOrderAmendmentCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\SalesOrderAmendmentCollectionTransfer
     */
    public function mapSalesOrderAmendmentEntitiesToSalesOrderAmendmentCollectionTransfer(
        ObjectCollection $salesOrderAmendmentEntities,
        SalesOrderAmendmentCollectionTransfer $salesOrderAmendmentCollectionTransfer
    ): SalesOrderAmendmentCollectionTransfer {
        foreach ($salesOrderAmendmentEntities as $salesOrderAmendmentEntity) {
            $salesOrderAmendmentCollectionTransfer->addSalesOrderAmendment(
                $this->mapSalesOrderAmendmentEntityToSalesOrderAmendmentTransfer(
                    $salesOrderAmendmentEntity,
                    new SalesOrderAmendmentTransfer(),
                ),
            );
        }

        return $salesOrderAmendmentCollectionTransfer;
    }

    public function mapSalesOrderAmendmentEntityToSalesOrderAmendmentTransfer(
        SpySalesOrderAmendment $salesOrderAmendmentEntity,
        SalesOrderAmendmentTransfer $salesOrderAmendmentTransfer
    ): SalesOrderAmendmentTransfer {
        return $salesOrderAmendmentTransfer->fromArray($salesOrderAmendmentEntity->toArray(), true);
    }
}
