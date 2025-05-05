<?php

namespace Achei\ReservationApi\Model;

use Achei\ReservationApi\Api\ReservationRepositoryInterface;
use Magento\Framework\App\ResourceConnection;

class ReservationRepository implements ReservationRepositoryInterface
{
    /**
     * @var ResourceConnection
     */
    private ResourceConnection $connection;

    /**
     * @param ResourceConnection $connection
     */
    public function __construct(
        ResourceConnection $connection,
    )
    {
        $this->connection = $connection;
    }

    /**
     * @inheritdoc
     */
    public function getBySku($sku)
    {
        $connection = $this->connection->getConnection();
        $tableName = $this->connection->getTableName('inventory_reservation');
        $query = $connection
            ->select()
            ->from($tableName)
            ->where('sku = ?', $sku);

        $result = $connection->fetchAll($query);
        return $result;
    }
}
