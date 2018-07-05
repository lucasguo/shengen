<?php
namespace backend\components;

use Yii;
use yii\base\Component;
use backend\models\OrderForm;
use backend\models\Customer;
use backend\models\MachineMaster;
use backend\models\MachineProduct;
use common\models\User;
use backend\models\OrderDetail;

class ExcelExport extends Component
{
	/**
	 * export order record into excel file
	 * @param $order OrderForm the order entry
	 * @return string|null file path for the file exported. Null if generation is failed
	 */
	public function exportOrder($order)
	{
		try {
			$order->initMachines();
	    	$customer = Customer::findOne($order->customer_id);
	    	$saler = User::findOne($customer->belongto);
	    	$machineSns = [];
	    	$orderDetails = OrderDetail::findAll(['master_id' => $order->id]);
	    	foreach ($orderDetails as $orderDetail) {
                $machine = MachineMaster::findOne($orderDetail->machine_id);
                $machineSns[] = $machine->machine_sn;
            }
            $singleCost = $order->sold_amount / $order->sold_count;
	    	$product = MachineProduct::findOne($machine->product_id);
	    	
	    	$source = Yii::getAlias('@backend') . '/data/sales.xlsx';
	    	$output = Yii::getAlias('@backend') . '/cache/' . $order->order_sn . '.xlsx';
	    	$format = \PHPExcel_IOFactory::identify($source);
	    	$objectreader = \PHPExcel_IOFactory::createReader($format);
	    	$objectPhpExcel = $objectreader->load($source);
	    	$objectPhpExcel->getActiveSheet()->setCellValue('C3', $customer->customer_name);
	    	$objectPhpExcel->getActiveSheet()->setCellValue('H3', $customer->customer_sn);
	    	$objectPhpExcel->getActiveSheet()->setCellValue('C4', $customer->customer_mobile);
	    	$objectPhpExcel->getActiveSheet()->setCellValue('H4', Yii::$app->formatter->asDate($order->sold_datetime));
	    	$objectPhpExcel->getActiveSheet()->setCellValue('C5', $customer->customer_address);
	    	$objectPhpExcel->getActiveSheet()->setCellValue('A7', $product->product_name);
	    	$objectPhpExcel->getActiveSheet()->setCellValue('D7', $product->product_code);
	    	$objectPhpExcel->getActiveSheet()->setCellValue('F7', $order->sold_count);
	    	$objectPhpExcel->getActiveSheet()->setCellValue('G7', Yii::$app->formatter->asCurrency($singleCost));
	    	$objectPhpExcel->getActiveSheet()->setCellValue('I7', Yii::$app->formatter->asCurrency($order->sold_amount));
//	    	$objectPhpExcel->getActiveSheet()->setCellValue('B8', Yii::$app->formatter->asCurrency($order->sold_amount));
	    	$objectPhpExcel->getActiveSheet()->setCellValue('B8', Yii::$app->formatter->asChineseMoney($order->sold_amount));
	    	if($order->need_invoice) {
	    		$objectPhpExcel->getActiveSheet()->setCellValue('H8', '包含发票 是√ 否□');
	    	} else {
	    		$objectPhpExcel->getActiveSheet()->setCellValue('H8', '包含发票 是□ 否√');
	    	}
//	    	$objectPhpExcel->getActiveSheet()->setCellValue('B8', Yii::$app->formatter->asCurrency($order->sold_amount));
            $objectPhpExcel->getActiveSheet()->getStyle('C9')->getAlignment()->setWrapText(true);
	    	$objectPhpExcel->getActiveSheet()->setCellValue('C9', implode("\n", $machineSns));
//	    	$objectPhpExcel->getActiveSheet()->setCellValue('H9', $machineDetail->field1);
//	    	$objectPhpExcel->getActiveSheet()->setCellValue('C10', $machineDetail->field2);
	    	$objectPhpExcel->getActiveSheet()->setCellValue('H11', $order->warranty_in_month . "个月");
            $objectPhpExcel->getActiveSheet()->setCellValue('C12', $saler->username);
	    	$objectPhpExcel->getActiveSheet()->setCellValue('H12', Yii::$app->params['contactPhone']);
	    	$objectPhpExcel->getActiveSheet()->setCellValue('H13', Yii::$app->params['contactPhone']);
	    	$objectPhpExcel->getActiveSheet()->setCellValue('C13', Yii::$app->params['companyName']);
	    	$objectPhpExcel->getActiveSheet()->setCellValue('C15', Yii::$app->formatter->asDate($order->created_at));
	    	$objectPhpExcel->getActiveSheet()->setCellValue('H15', Yii::$app->formatter->asDate(time()));
	    	$objectWriter = new \PHPExcel_Writer_Excel2007($objectPhpExcel);
	
	    	$objectWriter->save($output);
	    	return $output;
    	} catch (Exception $e) {
    		Yii::error("error generate excel. " . $e->getMessage());
    		return null;
    	}
	}

}