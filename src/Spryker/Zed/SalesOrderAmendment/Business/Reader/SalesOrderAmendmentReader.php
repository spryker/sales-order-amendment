<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Business\Reader;

use Generated\Shared\Transfer\SalesOrderAmendmentCollectionTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentCriteriaTransfer;
use Spryker\Zed\SalesOrderAmendment\Persistence\SalesOrderAmendmentRepositoryInterface;

class SalesOrderAmendmentReader implements SalesOrderAmendmentReaderInterface
{
    /**
     * @param \Spryker\Zed\SalesOrderAmendment\Persistence\SalesOrderAmendmentRepositoryInterface $salesOrderAmendmentRepository
     * @param list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentExpanderPluginInterface> $salesOrderAmendmentExpanderPlugins
     */
    public function __construct(
        protected SalesOrderAmendmentRepositoryInterface $salesOrderAmendmentRepository,
        protected array $salesOrderAmendmentExpanderPlugins
    ) {
    }

    public function getSalesOrderAmendmentCollection(
        SalesOrderAmendmentCriteriaTransfer $salesOrderAmendmentCriteriaTransfer
    ): SalesOrderAmendmentCollectionTransfer {
        $salesOrderAmendmentCollectionTransfer = $this->salesOrderAmendmentRepository
            ->getSalesOrderAmendmentCollection($salesOrderAmendmentCriteriaTransfer);

        return $this->executeSalesOrderAmendmentExpanderPlugins($salesOrderAmendmentCollectionTransfer);
    }

    protected function executeSalesOrderAmendmentExpanderPlugins(
        SalesOrderAmendmentCollectionTransfer $salesOrderAmendmentCollectionTransfer
    ): SalesOrderAmendmentCollectionTransfer {
        foreach ($this->salesOrderAmendmentExpanderPlugins as $salesOrderAmendmentExpanderPlugin) {
            $salesOrderAmendmentCollectionTransfer = $salesOrderAmendmentExpanderPlugin->expand(
                $salesOrderAmendmentCollectionTransfer,
            );
        }

        return $salesOrderAmendmentCollectionTransfer;
    }
}
