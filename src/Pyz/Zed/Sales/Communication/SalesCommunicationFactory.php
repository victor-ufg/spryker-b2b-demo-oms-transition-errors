<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Sales\Communication;

use Pyz\Zed\Oms\Business\OmsFacadeInterface;
use Pyz\Zed\Sales\SalesDependencyProvider;
use Spryker\Zed\Sales\Communication\SalesCommunicationFactory as SprykerSalesCommunicationFactory;

/**
 * @method \Spryker\Zed\Sales\Persistence\SalesRepositoryInterface getRepository()
 * @method \Spryker\Zed\Sales\Persistence\SalesEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\Sales\Business\SalesFacadeInterface getFacade()
 * @method \Pyz\Zed\Sales\SalesConfig getConfig()
 */
class SalesCommunicationFactory extends SprykerSalesCommunicationFactory
{
    /**
     * @return \Pyz\Zed\Oms\Business\OmsFacadeInterface
     */
    public function getPyzOmsFacade(): OmsFacadeInterface
    {
        return $this->getProvidedDependency(SalesDependencyProvider::FACADE_OMS_PYZ);
    }
}
