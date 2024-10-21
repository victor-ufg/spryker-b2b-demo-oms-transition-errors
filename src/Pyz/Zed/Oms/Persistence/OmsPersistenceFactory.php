<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Oms\Persistence;

use Pyz\Zed\Oms\Persistence\Propel\Mapper\LogTransitionErrorMapper;
use Spryker\Zed\Oms\Persistence\OmsPersistenceFactory as SprykerOmsPersistenceFactory;

/**
 * @method \Pyz\Zed\Oms\Persistence\OmsRepositoryInterface getRepository()
 * @method \Spryker\Zed\Oms\Persistence\OmsEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\Oms\OmsConfig getConfig()
 */
class OmsPersistenceFactory extends SprykerOmsPersistenceFactory
{
    /**
     * @return \Pyz\Zed\Oms\Persistence\Propel\Mapper\LogTransitionErrorMapper
     */
    public function createLogTransitionErrorMapper(): LogTransitionErrorMapper
    {
        return new LogTransitionErrorMapper();
    }
}
