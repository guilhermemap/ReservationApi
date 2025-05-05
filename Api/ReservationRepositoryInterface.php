<?php

namespace Achei\ReservationApi\Api;

interface ReservationRepositoryInterface
{
    /**
     * Get inventory reservations by SKU
     *
     * @param string $sku
     * @return array
     */
    public function getBySku(string $sku);
}
