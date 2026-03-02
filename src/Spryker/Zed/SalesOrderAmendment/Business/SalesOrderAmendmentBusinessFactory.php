<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Business;

use Spryker\Service\SalesOrderAmendment\SalesOrderAmendmentServiceInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\SalesOrderAmendment\Business\Checker\CartChecker;
use Spryker\Zed\SalesOrderAmendment\Business\Checker\CartCheckerInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Creator\SalesOrderAmendmentCreator;
use Spryker\Zed\SalesOrderAmendment\Business\Creator\SalesOrderAmendmentCreatorInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Creator\SalesOrderAmendmentQuoteCreator;
use Spryker\Zed\SalesOrderAmendment\Business\Creator\SalesOrderAmendmentQuoteCreatorInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Deleter\SalesOrderAmendmentDeleter;
use Spryker\Zed\SalesOrderAmendment\Business\Deleter\SalesOrderAmendmentDeleterInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Deleter\SalesOrderAmendmentQuoteDeleter;
use Spryker\Zed\SalesOrderAmendment\Business\Deleter\SalesOrderAmendmentQuoteDeleterInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Expander\CartReorderExpander;
use Spryker\Zed\SalesOrderAmendment\Business\Expander\CartReorderExpanderInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Expander\OrderExpander;
use Spryker\Zed\SalesOrderAmendment\Business\Expander\OrderExpanderInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Expander\QuoteExpander;
use Spryker\Zed\SalesOrderAmendment\Business\Expander\QuoteExpanderInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Filter\QuoteFieldsFilter;
use Spryker\Zed\SalesOrderAmendment\Business\Filter\QuoteFieldsFilterInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Hydrator\CartReorderItemHydrator;
use Spryker\Zed\SalesOrderAmendment\Business\Hydrator\CartReorderItemHydratorInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Mapper\SalesOrderAmendmentMapper;
use Spryker\Zed\SalesOrderAmendment\Business\Mapper\SalesOrderAmendmentMapperInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Mapper\SalesOrderAmendmentQuoteCriteriaMapper;
use Spryker\Zed\SalesOrderAmendment\Business\Mapper\SalesOrderAmendmentQuoteCriteriaMapperInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Reader\OrderReader;
use Spryker\Zed\SalesOrderAmendment\Business\Reader\OrderReaderInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Reader\SalesOrderAmendmentQuoteReader;
use Spryker\Zed\SalesOrderAmendment\Business\Reader\SalesOrderAmendmentQuoteReaderInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Reader\SalesOrderAmendmentReader;
use Spryker\Zed\SalesOrderAmendment\Business\Reader\SalesOrderAmendmentReaderInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Replacer\SalesOrderItemReplacer;
use Spryker\Zed\SalesOrderAmendment\Business\Replacer\SalesOrderItemReplacerInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Resolver\SalesOrderAmendmentAvailabilityResolver;
use Spryker\Zed\SalesOrderAmendment\Business\Resolver\SalesOrderAmendmentAvailabilityResolverInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Saver\SalesOrderAmendmentQuoteSaver;
use Spryker\Zed\SalesOrderAmendment\Business\Saver\SalesOrderAmendmentQuoteSaverInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Strategy\GroupKeyQuantitySalesOrderAmendmentItemCollectorStrategy;
use Spryker\Zed\SalesOrderAmendment\Business\Strategy\SalesOrderAmendmentItemCollectorStrategyInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Updater\SalesOrderAmendmentQuoteUpdater;
use Spryker\Zed\SalesOrderAmendment\Business\Updater\SalesOrderAmendmentQuoteUpdaterInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Updater\SalesOrderAmendmentUpdater;
use Spryker\Zed\SalesOrderAmendment\Business\Updater\SalesOrderAmendmentUpdaterInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Validator\CartReorderValidator;
use Spryker\Zed\SalesOrderAmendment\Business\Validator\CartReorderValidatorInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Validator\QuoteRequestValidator;
use Spryker\Zed\SalesOrderAmendment\Business\Validator\QuoteRequestValidatorInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Validator\Rules\SalesOrderAmendment\SalesOrderAmendmentExistsSalesOrderAmendmentValidatorRule;
use Spryker\Zed\SalesOrderAmendment\Business\Validator\Rules\SalesOrderAmendment\SalesOrderAmendmentValidatorRuleInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Validator\SalesOrderAmendmentQuoteValidator;
use Spryker\Zed\SalesOrderAmendment\Business\Validator\SalesOrderAmendmentQuoteValidatorInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Validator\SalesOrderAmendmentValidator;
use Spryker\Zed\SalesOrderAmendment\Business\Validator\SalesOrderAmendmentValidatorInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Validator\Util\ErrorAdder;
use Spryker\Zed\SalesOrderAmendment\Business\Validator\Util\ErrorAdderInterface;
use Spryker\Zed\SalesOrderAmendment\Dependency\Facade\SalesOrderAmendmentToQuoteFacadeInterface;
use Spryker\Zed\SalesOrderAmendment\Dependency\Facade\SalesOrderAmendmentToSalesFacadeInterface;
use Spryker\Zed\SalesOrderAmendment\SalesOrderAmendmentDependencyProvider;

/**
 * @method \Spryker\Zed\SalesOrderAmendment\SalesOrderAmendmentConfig getConfig()
 * @method \Spryker\Zed\SalesOrderAmendment\Persistence\SalesOrderAmendmentEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\SalesOrderAmendment\Persistence\SalesOrderAmendmentRepositoryInterface getRepository()
 */
class SalesOrderAmendmentBusinessFactory extends AbstractBusinessFactory
{
    public function createSalesOrderAmendmentReader(): SalesOrderAmendmentReaderInterface
    {
        return new SalesOrderAmendmentReader(
            $this->getRepository(),
            $this->getSalesOrderAmendmentExpanderPlugins(),
        );
    }

    public function createOrderReader(): OrderReaderInterface
    {
        return new OrderReader($this->getSalesFacade());
    }

    public function createSalesOrderAmendmentCreator(): SalesOrderAmendmentCreatorInterface
    {
        return new SalesOrderAmendmentCreator(
            $this->createSalesOrderAmendmentCreateValidator(),
            $this->getEntityManager(),
            $this->createSalesOrderAmendmentMapper(),
            $this->getSalesOrderAmendmentPreCreatePlugins(),
            $this->getSalesOrderAmendmentPostCreatePlugins(),
        );
    }

    public function createSalesOrderAmendmentQuoteCreator(): SalesOrderAmendmentQuoteCreatorInterface
    {
        return new SalesOrderAmendmentQuoteCreator(
            $this->getEntityManager(),
            $this->createQuoteFieldsFilter(),
        );
    }

    public function createSalesOrderAmendmentUpdater(): SalesOrderAmendmentUpdaterInterface
    {
        return new SalesOrderAmendmentUpdater(
            $this->createSalesOrderAmendmentUpdateValidator(),
            $this->getEntityManager(),
            $this->getSalesOrderAmendmentPreUpdatePlugins(),
            $this->getSalesOrderAmendmentPostUpdatePlugins(),
        );
    }

    public function createSalesOrderAmendmentQuoteUpdater(): SalesOrderAmendmentQuoteUpdaterInterface
    {
        return new SalesOrderAmendmentQuoteUpdater(
            $this->getEntityManager(),
            $this->createQuoteFieldsFilter(),
            $this->createSalesOrderAmendmentQuoteValidator(),
        );
    }

    public function createSalesOrderAmendmentDeleter(): SalesOrderAmendmentDeleterInterface
    {
        return new SalesOrderAmendmentDeleter(
            $this->getEntityManager(),
            $this->getRepository(),
            $this->getSalesOrderAmendmentPreDeletePlugins(),
            $this->getSalesOrderAmendmentPostDeletePlugins(),
        );
    }

    public function createSalesOrderAmendmentQuoteDeleter(): SalesOrderAmendmentQuoteDeleterInterface
    {
        return new SalesOrderAmendmentQuoteDeleter(
            $this->getRepository(),
            $this->getEntityManager(),
            $this->createSalesOrderAmendmentQuoteCriteriaMapper(),
        );
    }

    public function createSalesOrderAmendmentQuoteCriteriaMapper(): SalesOrderAmendmentQuoteCriteriaMapperInterface
    {
        return new SalesOrderAmendmentQuoteCriteriaMapper();
    }

    public function createCartReorderExpander(): CartReorderExpanderInterface
    {
        return new CartReorderExpander(
            $this->getSalesOrderAmendmentService(),
        );
    }

    public function createOrderExpander(): OrderExpanderInterface
    {
        return new OrderExpander($this->createSalesOrderAmendmentReader());
    }

    public function createQuoteExpander(): QuoteExpanderInterface
    {
        return new QuoteExpander($this->createOrderReader());
    }

    public function createSalesOrderAmendmentMapper(): SalesOrderAmendmentMapperInterface
    {
        return new SalesOrderAmendmentMapper();
    }

    public function createSalesOrderAmendmentCreateValidator(): SalesOrderAmendmentValidatorInterface
    {
        return new SalesOrderAmendmentValidator(
            $this->getSalesOrderAmendmentCreateValidatorRules(),
            $this->getSalesOrderAmendmentCreateValidationRulePlugins(),
        );
    }

    public function createSalesOrderAmendmentUpdateValidator(): SalesOrderAmendmentValidatorInterface
    {
        return new SalesOrderAmendmentValidator(
            $this->getSalesOrderAmendmentUpdateValidatorRules(),
            $this->getSalesOrderAmendmentUpdateValidationRulePlugins(),
        );
    }

    public function createSalesOrderAmendmentQuoteValidator(): SalesOrderAmendmentQuoteValidatorInterface
    {
        return new SalesOrderAmendmentQuoteValidator($this->getRepository());
    }

    public function createCartReorderValidator(): CartReorderValidatorInterface
    {
        return new CartReorderValidator();
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendment\Business\Validator\Rules\SalesOrderAmendment\SalesOrderAmendmentValidatorRuleInterface>
     */
    public function getSalesOrderAmendmentCreateValidatorRules(): array
    {
        return [];
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendment\Business\Validator\Rules\SalesOrderAmendment\SalesOrderAmendmentValidatorRuleInterface>
     */
    public function getSalesOrderAmendmentUpdateValidatorRules(): array
    {
        return [
            $this->createSalesOrderAmendmentExistsSalesOrderAmendmentValidatorRule(),
        ];
    }

    public function createSalesOrderAmendmentExistsSalesOrderAmendmentValidatorRule(): SalesOrderAmendmentValidatorRuleInterface
    {
        return new SalesOrderAmendmentExistsSalesOrderAmendmentValidatorRule(
            $this->getRepository(),
            $this->createErrorAdder(),
        );
    }

    public function createErrorAdder(): ErrorAdderInterface
    {
        return new ErrorAdder();
    }

    public function createQuoteFieldsFilter(): QuoteFieldsFilterInterface
    {
        return new QuoteFieldsFilter($this->getConfig());
    }

    public function createCartReorderItemHydrator(): CartReorderItemHydratorInterface
    {
        return new CartReorderItemHydrator();
    }

    public function createSalesOrderItemReplacer(): SalesOrderItemReplacerInterface
    {
        return new SalesOrderItemReplacer(
            $this->createGroupKeyQuantitySalesOrderAmendmentItemCollectorStrategy(),
            $this->getSalesFacade(),
            $this->getSalesOrderAmendmentItemCollectorStrategyPlugins(),
            $this->getSalesOrderItemCollectorPlugins(),
        );
    }

    public function createGroupKeyQuantitySalesOrderAmendmentItemCollectorStrategy(): SalesOrderAmendmentItemCollectorStrategyInterface
    {
        return new GroupKeyQuantitySalesOrderAmendmentItemCollectorStrategy();
    }

    public function createCartChecker(): CartCheckerInterface
    {
        return new CartChecker(
            $this->createOrderReader(),
        );
    }

    public function createQuoteRequestValidator(): QuoteRequestValidatorInterface
    {
        return new QuoteRequestValidator();
    }

    public function createSalesOrderAmendmentAvailabilityResolver(): SalesOrderAmendmentAvailabilityResolverInterface
    {
        return new SalesOrderAmendmentAvailabilityResolver($this->getSalesOrderAmendmentService());
    }

    public function createSalesOrderAmendmentQuoteReader(): SalesOrderAmendmentQuoteReaderInterface
    {
        return new SalesOrderAmendmentQuoteReader(
            $this->getRepository(),
            $this->getSalesOrderAmendmentQuoteExpanderPlugins(),
        );
    }

    public function createSalesOrderAmendmentQuoteSaver(): SalesOrderAmendmentQuoteSaverInterface
    {
        return new SalesOrderAmendmentQuoteSaver(
            $this->createSalesOrderAmendmentQuoteCreator(),
            $this->createSalesOrderAmendmentQuoteReader(),
        );
    }

    public function getSalesFacade(): SalesOrderAmendmentToSalesFacadeInterface
    {
        return $this->getProvidedDependency(SalesOrderAmendmentDependencyProvider::FACADE_SALES);
    }

    public function getQuoteFacade(): SalesOrderAmendmentToQuoteFacadeInterface
    {
        return $this->getProvidedDependency(SalesOrderAmendmentDependencyProvider::FACADE_QUOTE);
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentExpanderPluginInterface>
     */
    public function getSalesOrderAmendmentExpanderPlugins(): array
    {
        return $this->getProvidedDependency(SalesOrderAmendmentDependencyProvider::PLUGINS_SALES_ORDER_AMENDMENT_EXPANDER);
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentValidatorRulePluginInterface>
     */
    public function getSalesOrderAmendmentCreateValidationRulePlugins(): array
    {
        return $this->getProvidedDependency(SalesOrderAmendmentDependencyProvider::PLUGINS_SALES_ORDER_AMENDMENT_CREATE_VALIDATION_RULE);
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentPreCreatePluginInterface>
     */
    public function getSalesOrderAmendmentPreCreatePlugins(): array
    {
        return $this->getProvidedDependency(SalesOrderAmendmentDependencyProvider::PLUGINS_SALES_ORDER_AMENDMENT_PRE_CREATE);
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentPostCreatePluginInterface>
     */
    public function getSalesOrderAmendmentPostCreatePlugins(): array
    {
        return $this->getProvidedDependency(SalesOrderAmendmentDependencyProvider::PLUGINS_SALES_ORDER_AMENDMENT_POST_CREATE);
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentValidatorRulePluginInterface>
     */
    public function getSalesOrderAmendmentUpdateValidationRulePlugins(): array
    {
        return $this->getProvidedDependency(SalesOrderAmendmentDependencyProvider::PLUGINS_SALES_ORDER_AMENDMENT_UPDATE_VALIDATION_RULE);
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentPreUpdatePluginInterface>
     */
    public function getSalesOrderAmendmentPreUpdatePlugins(): array
    {
        return $this->getProvidedDependency(SalesOrderAmendmentDependencyProvider::PLUGINS_SALES_ORDER_AMENDMENT_PRE_UPDATE);
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentPostUpdatePluginInterface>
     */
    public function getSalesOrderAmendmentPostUpdatePlugins(): array
    {
        return $this->getProvidedDependency(SalesOrderAmendmentDependencyProvider::PLUGINS_SALES_ORDER_AMENDMENT_POST_UPDATE);
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentPreDeletePluginInterface>
     */
    public function getSalesOrderAmendmentPreDeletePlugins(): array
    {
        return $this->getProvidedDependency(SalesOrderAmendmentDependencyProvider::PLUGINS_SALES_ORDER_AMENDMENT_PRE_DELETE);
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentPostDeletePluginInterface>
     */
    public function getSalesOrderAmendmentPostDeletePlugins(): array
    {
        return $this->getProvidedDependency(SalesOrderAmendmentDependencyProvider::PLUGINS_SALES_ORDER_AMENDMENT_POST_DELETE);
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentItemCollectorStrategyPluginInterface>
     */
    public function getSalesOrderAmendmentItemCollectorStrategyPlugins(): array
    {
        return $this->getProvidedDependency(SalesOrderAmendmentDependencyProvider::PLUGINS_SALES_ORDER_AMENDMENT_ITEM_COLLECTOR_STRATEGY);
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderItemCollectorPluginInterface>
     */
    public function getSalesOrderItemCollectorPlugins(): array
    {
        return $this->getProvidedDependency(SalesOrderAmendmentDependencyProvider::PLUGINS_SALES_ORDER_ITEM_COLLECTOR_PLUGIN);
    }

    /**
     * @return list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentQuoteExpanderPluginInterface>
     */
    public function getSalesOrderAmendmentQuoteExpanderPlugins(): array
    {
        return $this->getProvidedDependency(SalesOrderAmendmentDependencyProvider::PLUGINS_SALES_ORDER_AMENDMENT_QUOTE_EXPANDER);
    }

    public function getSalesOrderAmendmentService(): SalesOrderAmendmentServiceInterface
    {
        return $this->getProvidedDependency(SalesOrderAmendmentDependencyProvider::SERVICE_SALES_ORDER_AMENDMENT);
    }
}
