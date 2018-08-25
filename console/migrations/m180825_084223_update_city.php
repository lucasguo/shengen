<?php

use yii\db\Migration;

/**
 * Class m180825_084223_update_city
 */
class m180825_084223_update_city extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        CREATE TEMPORARY TABLE ID_CITY_MAPPING AS
        (select c.id, h.hospital_city
        FROM
          customer_new c
        LEFT JOIN
          customer_hospital_mapping m
        ON
          c.id = m.customer_id
        LEFT JOIN
          hospital h
        ON
          m.hospital_id = h.id
        GROUP by c.id);
        UPDATE customer_new c
        LEFT JOIN ID_CITY_MAPPING m on c.id = m.id
        SET c.city_id = m.hospital_city;
        ");

        $this->execute("
        update region set id = 18375 where id = 1303;
        update region set id = 18376 where id = 1329;
        update region set id = 18377 where id = 1332;
        update region set id = 18378 where id = 1315;
        update region set id = 18379 where id = 1341;
        update region set id = 18380 where id = 1362;
        update region set id = 18381 where id = 1317;
        update region set id = 18382 where id = 1352;
        update region set id = 18383 where id = 1370;
        
        update region set parent_id = 18375 where parent_id = 1303;
        update region set parent_id = 18376 where parent_id = 1329;
        update region set parent_id = 18377 where parent_id = 1332;
        update region set parent_id = 18378 where parent_id = 1315;
        update region set parent_id = 18379 where parent_id = 1341;
        update region set parent_id = 18380 where parent_id = 1362;
        update region set parent_id = 18381 where parent_id = 1317;
        update region set parent_id = 18382 where parent_id = 1352;
        update region set parent_id = 18383 where parent_id = 1370;
        
        update customer_new set city_id = 18375 where city_id = 1303;
        update customer_new set city_id = 18376 where city_id = 1329;
        update customer_new set city_id = 18377 where city_id = 1332;
        update customer_new set city_id = 18378 where city_id = 1315;
        update customer_new set city_id = 18379 where city_id = 1341;
        update customer_new set city_id = 18380 where city_id = 1362;
        update customer_new set city_id = 18381 where city_id = 1317;
        update customer_new set city_id = 18382 where city_id = 1352;
        update customer_new set city_id = 18383 where city_id = 1370;
        
        update hospital set hospital_city = 18375 where hospital_city = 1303;
        update hospital set hospital_city = 18376 where hospital_city = 1329;
        update hospital set hospital_city = 18377 where hospital_city = 1332;
        update hospital set hospital_city = 18378 where hospital_city = 1315;
        update hospital set hospital_city = 18379 where hospital_city = 1341;
        update hospital set hospital_city = 18380 where hospital_city = 1362;
        update hospital set hospital_city = 18381 where hospital_city = 1317;
        update hospital set hospital_city = 18382 where hospital_city = 1352;
        update hospital set hospital_city = 18383 where hospital_city = 1370;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m180825_084223_update_city cannot be reverted.\n";
//
//        return false;
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180825_084223_update_city cannot be reverted.\n";

        return false;
    }
    */
}
