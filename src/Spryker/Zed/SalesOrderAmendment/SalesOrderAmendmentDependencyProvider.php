<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\SalesOrderAmendment\Dependency\Service\SalesOrderAmendmentToUtilEncodingServiceBridge;

/**
 * @method \Spryker\Zed\SalesOrderAmendment\SalesOrderAmendmentConfig getConfig()
 */
class SalesOrderAmendmentDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const SERVICE_UTIL_ENCODING = 'SERVICE_UTIL_ENCODING';

    /**
     * @var string
     */
    public const PLUGINS_SALES_ORDER_AMENDMENT_EXPANDER = 'PLUGINS_SALES_ORDER_AMENDMENT_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_SALES_ORDER_AMENDMENT_CREATE_VALIDATION_RULE = 'PLUGINS_SALES_ORDER_AMENDMENT_CREATE_VALIDATION_RULE';

    /**
     * @var string
     */
    public const PLUGINS_SALES_ORDER_AMENDMENT_UPDATE_VALIDATION_RULE = 'PLUGINS_SALES_ORDER_AMENDMENT_UPDATE_VALIDATION_RULE';

    /**
     * @var string
     */
    public const PLUGINS_SALES_ORDER_AMENDMENT_PRE_CREATE = 'PLUGINS_SALES_ORDER_AMENDMENT_PRE_CREATE';

    /**
     * @var string
     */
    public const PLUGINS_SALES_ORDER_AMENDMENT_POST_CREATE = 'PLUGINS_SALES_ORDER_AMENDMENT_POST_CREATE';

    /**
     * @var string
     */
    public const PLUGINS_SALES_ORDER_AMENDMENT_PRE_UPDATE = 'PLUGINS_SALES_ORDER_AMENDMENT_PRE_UPDATE';

    /**
     * @var string
     */
    public const PLUGINS_SALES_ORDER_AMENDMENT_POST_UPDATE = 'PLUGINS_SALES_ORDER_AMENDMENT_POST_UPDATE';

    /**
     * @var string
     */
    public const PLUGINS_SALES_ORDER_AMENDMENT_PRE_DELETE = 'PLUGINS_SALES_ORDER_AMENDMENT_PRE_DELETE';

    /**
     * @var string
     */
    public const PLUGINS_SALES_ORDER_AMENDMENT_POST_DELETE = 'PLUGINS_SALES_ORDER_AMENDMENT_POST_DELETE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addSalesOrderAmendmentExpanderPlugins($container);
        $container = $this->addSalesOrderAmendmentCreateValidationRulePlugins($container);
        $container = $this->addSalesOrderAmendmentPreCreatePlugins($container);
        $container = $this->addSalesOrderAmendmentPostCreatePlugins($container);
        $container = $this->addSalesOrderAmendmentUpdateValidationRulePlugins($container);
        $container = $this->addSalesOrderAmendmentPreUpdatePlugins($container);
        $container = $this->addSalesOrderAmendmentPostUpdatePlugins($container);
        $container = $this->addSalesOrderAmendmentPreDeletePlugins($container);
        $container = $this->addSalesOrderAmendmentPostDeletePlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = $this->addUtilEncodingService($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addUtilEncodingService(Container $container): Container
    {
        $container->set(static::SERVICE_UTIL_ENCODING, function (Container $container) {
            return new SalesOrderAmendmentToUtilEncodingServiceBridge($container->getLocator()->utilEncoding()->service());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSalesOrderAmendmentExpanderPlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_SALES_ORDER_AMENDMENT_EXPANDER, function () {
            return $this->getSalesOrderAmendmentExpanderPlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSalesOrderAmendmentCreateValidationRulePlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_SALES_ORDER_AMENDMENT_CREATE_VALIDATION_RULE, function () {
            return $this->getSalesOrderAmendmentCreateValidationRulePlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSalesOrderAmendmentPreCreatePlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_SALES_ORDER_AMENDMENT_PRE_CREATE, function () {
            return $this->getSalesOrderAmendmentPreCreatePlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSalesOrderAmendmentPostCreatePlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_SALES_ORDER_AMENDMENT_POST_CREATE, function () {
            return $this->getSalesOrderAmendmentPostCreatePlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSalesOrderAmendmentUpdateValidationRulePlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_SALES_ORDER_AMENDMENT_UPDATE_VALIDATION_RULE, function () {
            return $this->getSalesOrderAmendmentUpdateValidationRulePlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSalesOrderAmendmentPreUpdatePlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_SALES_ORDER_AMENDMENT_PRE_UPDATE, function () {
            return $this->getSalesOrderAmendmentPreUpdatePlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSalesOrderAmendmentPostUpdatePlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_SALES_ORDER_AMENDMENT_POST_UPDATE, function () {
            return $this->getSalesOrderAmendmentPostUpdatePlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSalesOrderAmendmentPreDeletePlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_SALES_ORDER_AMENDMENT_PRE_DELETE, function () {
            return $this->getSalesOrderAmendmentPreDeletePlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSalesOrderAmendmentPostDeletePlugins(Container $container): Container
    {
        $container->set(static::PLUGINS_SALES_ORDER_AMENDMENT_POST_DELETE, function () {
            return $this->getSalesOrderAmendmentPostDeletePlugins();
        });

        return $container;
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentExpanderPluginInterface>
     */
    protected function getSalesOrderAmendmentExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentValidatorRulePluginInterface>
     */
    protected function getSalesOrderAmendmentCreateValidationRulePlugins(): array
    {
        return [];
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentPreCreatePluginInterface>
     */
    protected function getSalesOrderAmendmentPreCreatePlugins(): array
    {
        return [];
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentPostCreatePluginInterface>
     */
    protected function getSalesOrderAmendmentPostCreatePlugins(): array
    {
        return [];
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentValidatorRulePluginInterface>
     */
    protected function getSalesOrderAmendmentUpdateValidationRulePlugins(): array
    {
        return [];
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentPreUpdatePluginInterface>
     */
    protected function getSalesOrderAmendmentPreUpdatePlugins(): array
    {
        return [];
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentPostUpdatePluginInterface>
     */
    protected function getSalesOrderAmendmentPostUpdatePlugins(): array
    {
        return [];
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentPreDeletePluginInterface>
     */
    protected function getSalesOrderAmendmentPreDeletePlugins(): array
    {
        return [];
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentPostDeletePluginInterface>
     */
    protected function getSalesOrderAmendmentPostDeletePlugins(): array
    {
        return [];
    }
}
