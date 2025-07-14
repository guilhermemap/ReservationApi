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
        $result = $connection->query("select r.* from inventory_reservation r
        left join inventory_reservation r2 on
            JSON_EXTRACT(r.metadata,'$.object_increment_id')=JSON_UNQUOTE(JSON_EXTRACT(r2.metadata,'$.object_increment_id'))
            and r.reservation_id!=r2.reservation_id and r.sku=r2.sku
        where (r2.reservation_id is null or r.quantity!=r2.quantity*-1)
            and r.sku=?;", [$sku])->fetchAll();


        return $result;
    }
}
