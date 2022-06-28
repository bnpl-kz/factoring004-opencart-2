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

    public function install()
    {
        $this->db->query(sprintf(
            'CREATE TABLE IF NOT EXISTS %s (
                id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                order_id INT UNSIGNED NOT NULL,
                preapp_uid VARCHAR(255) NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            )',
            $this->db->escape($this->tableName)
        ));
    }

    public function uninstall()
    {
        $this->db->query(
            sprintf('DROP TABLE IF EXISTS %s', $this->db->escape($this->tableName))
        );
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
                $this->db->escape($preappId)
            )
        );
    }
}
