<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Oms\Persistence;

use Generated\Shared\Transfer\OmsTransitionErrorCollectionTransfer;
use Orm\Zed\Oms\Persistence\Map\SpyOmsTransitionLogTableMap;
use Spryker\Zed\Oms\Persistence\OmsRepository as SprykerOmsRepository;

/**
 * @method \Pyz\Zed\Oms\Persistence\OmsPersistenceFactory getFactory()
 */
class OmsRepository extends SprykerOmsRepository
{
    /**
     * @var int
     */
    public const PDO_FETCH_ASSOC = 2;

    /**
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\OmsTransitionErrorCollectionTransfer
     */
    public function getCurrentTransitionErrorsInLogByIdOrder(int $idSalesOrder): OmsTransitionErrorCollectionTransfer
    {
        # @todo: Use orm? I couldn't get propel to generate my statement.
        $sql_statement = $this->buildGetCurrentErrorsInLogByIdOrderSqlStatement($idSalesOrder);
        $sql_connection = $this->getFactory()->getOmsQueryContainer()->getConnection();

        $log_errors_pdo_results = $sql_connection->query($sql_statement)->fetchAll(static::PDO_FETCH_ASSOC);

        return $this->getFactory()->createLogTransitionErrorMapper()
            ->mapOmsTransitionLogCollectionToOmsTransitionErrorTransfers($log_errors_pdo_results);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return string
     */
    private function buildGetCurrentErrorsInLogByIdOrderSqlStatement(int $idSalesOrder): string
    {
        return sprintf(
            'SELECT
                            %s,
                            %s,
                            %s,
                            %s,
                            %s
                        FROM %s
                            INNER JOIN (
                                SELECT
                                    MAX(%s) as id_oms_transition_log
                                FROM %s
                                GROUP BY
                                    %s,
                                    %s
                            ) as last_transition
                                ON %s = last_transition.id_oms_transition_log
                        WHERE
                            %s = %u
                          AND %s IS NOT NULL
                          ',
            # Select
            SpyOmsTransitionLogTableMap::COL_FK_SALES_ORDER,
            SpyOmsTransitionLogTableMap::COL_FK_SALES_ORDER_ITEM,
            SpyOmsTransitionLogTableMap::COL_ERROR_MESSAGE,
            SpyOmsTransitionLogTableMap::COL_EVENT,
            SpyOmsTransitionLogTableMap::COL_SOURCE_STATE,
            # From
            SpyOmsTransitionLogTableMap::TABLE_NAME,
            # Inner Join
            SpyOmsTransitionLogTableMap::COL_ID_OMS_TRANSITION_LOG,
            SpyOmsTransitionLogTableMap::TABLE_NAME,
            # Group By
            SpyOmsTransitionLogTableMap::COL_FK_SALES_ORDER,
            SpyOmsTransitionLogTableMap::COL_FK_SALES_ORDER_ITEM,
            # On
            SpyOmsTransitionLogTableMap::COL_ID_OMS_TRANSITION_LOG,
            SpyOmsTransitionLogTableMap::COL_FK_SALES_ORDER,
            # Where
            $idSalesOrder,
            SpyOmsTransitionLogTableMap::COL_IS_ERROR,
        );
    }
}
