<?php

/**
 * @property-read \DB $db
 */
class ModelExtensionPaymentFactoring004 extends Model
{
    const MIN_TOTAL_PRICE = 6000;
    const MAX_TOTAL_PRICE = 200000;

    /**
     * @var string
     */
    private $tableName;

    public function __construct($registry)
    {
        parent::__construct($registry);

        $this->tableName = DB_PREFIX . 'factoring004_order_preapps';
    }

    public function getMethod($address, $total)
    {
        $this->load->language('extension/payment/factoring004');
        $price = ceil($total);
        $file = $this->config->get('payment_factoring004_agreement_file');
        if ($price < self::MIN_TOTAL_PRICE || $price > self::MAX_TOTAL_PRICE) {
            return [];
        }

        return array(
            'code'       => 'factoring004',
            'title'      => $this->language->get('text_title'),
            'terms'      => $file ? "<a target='_blank' href='../image/$file'>Оферта</a>" : '',
            'sort_order' => 0
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
                "INSERT INTO %s (order_id, preapp_uid) VALUES (%d, '%s')",
                $this->db->escape($this->tableName),
                $this->db->escape($orderId),
                $this->db->escape($preappId),
            )
        );
    }
}
