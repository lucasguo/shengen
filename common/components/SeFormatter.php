<?php
namespace common\components;

use yii\i18n\Formatter;
use yii\base\InvalidParamException;

class SeFormatter extends Formatter
{
	/**
	 * convert an amount value into Chinese number form.
	 * e.g. 10000 will be converted into 壹万元整
	 * @param integer $value
	 * @return string
	 */
	public function asChineseMoney($num)
	{
		$d = array('零','壹','贰','叁','肆','伍','陆','柒','捌','玖');
		$e = array('元','拾','佰','仟','万','拾万','佰万','仟万','亿','拾亿','佰亿','仟亿','万亿');
		$p = array('分','角');
		$zheng='整'; //追加"整"字
		$final = array(); //结果
		$inwan=0; //是否有万
		$inyi=0; //是否有亿
		$len_pointdigit=0; //小数点后长度
		$y=0;
		if($c = strpos($num, '.')) {    //有小数点,$c为小数点前有几位数
			$len_pointdigit = strlen($num)-strpos($num, '.')-1; // 判断小数点后有几位数
			if($c>13) { //简单的错误处理
				throw new InvalidParamException("数额太大,已经超出万亿.");
				die();
			} elseif($len_pointdigit>2) {   //$len_pointdigit小数点后有几位
				throw new InvalidParamException("小数点后只支持2位.");
			}
		} else {    //无小数点
			$c = strlen($num);
			$zheng = '整';
		}
		for($i=0;$i<$c;$i++) {  //处理整数部分
			$bit_num = substr($num, $i, 1); //逐字读取 左->右
			if($bit_num!=0 || substr($num, $i+1, 1)!=0) //当前是零 下一位还是零的话 就不显示
				@$low2chinses = $low2chinses.$d[$bit_num];
			if($bit_num || $i==$c-1)
				@$low2chinses = $low2chinses.$e[$c-$i-1];
		}
		for($j=$len_pointdigit; $j>=1; $j--) {  //处理小数部分
			$point_num = substr($num, strlen($num)-$j, 1); //逐字读取 左->右
			if($point_num != 0)
				@$low2chinses = $low2chinses.$d[$point_num].$p[$j-1];
			//  if(substr($num, strlen($num)-2, 1)==0 && substr($num, strlen($num)-1, 1)==0) //小数点后两位都是0
		}
		$chinses = str_split($low2chinses,2); //字符串转换成数组
		//print_r($chinses);
		for($x=sizeof($chinses)-1;$x>=0;$x--) {     //过滤无效的信息
			if($inwan==0&&$chinses[$x]==$e[4]) {    //过滤重复的"万"
				$final[$y++] = $chinses[$x];
				$inwan=1;
			}
			if($inyi==0&&$chinses[$x]==$e[8]) {     //过滤重复的"亿"
				$final[$y++] = $chinses[$x];
				$inyi=1;
				$inwan=0;
			}
			if($chinses[$x]!=$e[4]&&$chinses[$x]!=$e[8]) //进行整理,将最后的值赋予$final数组
				$final[$y++] = $chinses[$x];
		}
		$newstring=(array_reverse($final)); //$final为倒数组，$newstring为正常可以使用的数组
		$nstring=join($newstring); //数组变成字符串
		if(substr($num,-2,1)==0 && substr($num,-1)<>0) {    //判断原金额角位为0 ? 分位不为0 ?
			$nstring=substr($nstring,0,(strlen($nstring)-4))."零".substr($nstring,-4,4); //这样加一个零字
		}
		$fen="分";
		$fj=substr_count($nstring, $fen); //如果没有查到分这个字
		return $nstring=($fj==0)?$nstring.$zheng:$nstring; //就将"整"加到后面
	}
}