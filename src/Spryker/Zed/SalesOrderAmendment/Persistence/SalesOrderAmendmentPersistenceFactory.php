<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Persistence;

use Orm\Zed\SalesOrderAmendment\Persistence\SpySalesOrderAmendmentQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use Spryker\Zed\SalesOrderAmendment\Persistence\Propel\Mapper\SalesOrderAmendmentMapper;

/**
 * @method \Spryker\Zed\SalesOrderAmendment\SalesOrderAmendmentConfig getConfig()
 * @method \Spryker\Zed\SalesOrderAmendment\Persistence\SalesOrderAmendmentRepositoryInterface getRepository()
 * @method \Spryker\Zed\SalesOrderAmendment\Persistence\SalesOrderAmendmentEntityManagerInterface getEntityManager()
 */
class SalesOrderAmendmentPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\SalesOrderAmendment\Persistence\SpySalesOrderAmendmentQuery
     */
    public function getSalesOrderAmendmentQuery(): SpySalesOrderAmendmentQuery
    {
        return SpySalesOrderAmendmentQuery::create();
    }

    /**
     * @return \Spryker\Zed\SalesOrderAmendment\Persistence\Propel\Mapper\SalesOrderAmendmentMapper
     */
    public function createSalesOrderAmendmentMapper(): SalesOrderAmendmentMapper
    {
        return new SalesOrderAmendmentMapper();
    }
}