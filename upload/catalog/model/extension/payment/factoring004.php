<?php

/**
 * @property-read \DB $db
 */
class ModelExtensionPaymentFactoring004 extends Model
{
    /**
     * @var string
     */
    private $tableName;

    public function __construct($registry)
    {
        parent::__construct($registry);

        $this->tableName = DB_PREFIX . 'factoring004_order_preapps';
    }

    /**
     * @param int|string $orderId
     * @param string $preappId
     *
     * @return void
     */
    public function add($orderId, $preappId)
    {
        $this->db->query(
            sprintf(
                'INSERT INTO %s (order_id, preapp_uid) VALUES (%d, %s)',
                $this->db->escape($this->tableName),
                $this->db->escape($orderId),
                $this->db->escape($preappId),
            )
        );
    }
}
