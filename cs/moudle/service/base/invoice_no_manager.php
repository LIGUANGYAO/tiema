<?php

/**
 * 快递单效验类
 * @author baison
 */
class invoice_no_manager
{
	/**
	 * 快递单效验
	 *
	 * @param string $invoice_no				快递单号
	 * @param string $logistics_company_code	快递公司代码
	 *
	 * @return int 0:匹配成功;-1:匹配失败;-2:不存在此快递公司代码的效验规则
	 */
	public static function check($invoice_no,$logistics_company_code)
	{
		$result = array();
		$result['code'] = -1;
		$result['message'] = '运单号不符合规则!';

		$logisticsCompanies = invoice_no_manager::getLogisticsCompanies();

		$exist = false;
		foreach ($logisticsCompanies as $logisticsCompanie)
		{
			if(strtoupper($logistics_company_code) == $logisticsCompanie['code'])
			{
				if(!empty($logisticsCompanie['reg_mail_no']))
				{
					if(preg_match($logisticsCompanie['reg_mail_no'], $invoice_no))
					{
						$result['code'] = 0;
						$result['message'] = '运单号符合规则!';
					}
				}
				else {
					$result['code'] = 0;
					$result['message'] = '运单号符合规则!';
				}
				$exist = true;
			}
		}

		if(!$exist){
			$result['code'] = -2;
		    $result['message'] = '物流公司不存在!';
		}
		return $result;
	}

	/**
	 * 获取物流公司列表
	 *
	 */
	public static function getLogisticsCompanies()
	{
		$rfc = new ReflectionClass('LogisticsCompanies');
		$rfc_ins = $rfc->newInstance();
	    $properties = $rfc->getProperties();
	    $propertyValues = array();

	    foreach ($properties as $p)
	    {
	    	$propertyValues[$p->getName()] = $p->getValue($rfc_ins);
	    }

	    return $propertyValues;
	}
}

/**
 * 系统支持效验的物流公司信息
 * 注意：物流公司代码必须大写
 *
 * @author baison
 *
 */
class LogisticsCompanies
{
	public $post 	= array('code'=>'POST','name'=>'中国邮政平邮','reg_mail_no'=>'');
	public $ems 	= array('code'=>'EMS','name'=>'EMS','reg_mail_no'=>'/^[A-Z]{2}[0-9]{9}[A-Z]{2}$/');
	public $yto 	= array('code'=>'YTO','name'=>'圆通速递','reg_mail_no'=>'/^(0|1|2|3|5|6|7|8|E|D|F|G|V|W|e|d|f|g|v|w)[0-9]{9}$/');
	public $zto 	= array('code'=>'ZTO','name'=>'中通速递','reg_mail_no'=>'/^((618|680|688|6181|828|988|571|518|010|628|205|88|)[0-9]{9})$|^((2008|2010)[0-9]{8})$|^((00|10)[0-9]{10})$/');
	public $zjs 	= array('code'=>'ZJS','name'=>'宅急送','reg_mail_no'=>'/^[0-9]{10}$/');
	public $hzabc 	= array('code'=>'HZABC','name'=>'杭州爱彼西','reg_mail_no'=>'/^[0-9]{10,11}$/');
	public $yunda 	= array('code'=>'YUNDA','name'=>'韵达快运','reg_mail_no'=>'/^[0-9]{13}$/');
	public $ttkdex 	= array('code'=>'TTKDEX','name'=>'天天快递','reg_mail_no'=>'/^[0-9]{12,14}$/');
	public $fedex 	= array('code'=>'FEDEX','name'=>'联邦快递','reg_mail_no'=>'/^[0-9]{12}$/');
	public $ebon 	= array('code'=>'EBON','name'=>'一邦速递','reg_mail_no'=>'/^[0-9]{10}$/');
	public $stars 	= array('code'=>'STARS','name'=>'星晨急便','reg_mail_no'=>'/^[0-9]{10}$/');
	public $dbl 	= array('code'=>'STARS','name'=>'德邦物流','reg_mail_no'=>'/^[0-9]?[0-9]{7}$/');
	public $cre 	= array('code'=>'CRE','name'=>'中铁快运','reg_mail_no'=>'/^K[0-9]{11}$/');
	public $shq 	= array('code'=>'SHQ','name'=>'华强物流','reg_mail_no'=>'/^[A-Za-z0-9]*[0|2|4|6|8]$/');
	public $htky 	= array('code'=>'HTKY','name'=>'汇通快运','reg_mail_no'=>'/^(A|B|C|D|E|H|0)(D|X|[0-9])(A|[0-9])[0-9]{10}$|^(21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39)[0-9]{10}$/');
	public $wlbstars= array('code'=>'WLB-STARS','name'=>'星辰急便','reg_mail_no'=>'/^TB[0-9]{12}$/');
	public $wlbsad  = array('code'=>'WLB-SAD','name'=>'赛澳递','reg_mail_no'=>'/^TB[0-9]{12}$/');
	public $wlbabc  = array('code'=>'WLB-ABC','name'=>'浙江ABC','reg_mail_no'=>'/^TB[0-9]{12}$/');
	public $sf      = array('code'=>'SF','name'=>'顺丰速运','reg_mail_no'=>'/^[0-9]{12}$/');
	public $lbex      = array('code'=>'LBEX','name'=>'龙邦快递','reg_mail_no'=>'/^[0-9]{12}$/');
	public $cces      = array('code'=>'CCES','name'=>'CCES','reg_mail_no'=>'/^(2|3|5|6|8|5)[0-9]{9}$/');
	public $zy      = array('code'=>'ZY','name'=>'中远','reg_mail_no'=>'/^CO[A-Z]{2}[0-9]{10}$/');
	public $yct      = array('code'=>'YCT','name'=>'黑猫宅急便','reg_mail_no'=>'/^[0-9]{12}$/');
	public $dfh      = array('code'=>'DFH','name'=>'东方汇','reg_mail_no'=>'/^[0-9]{10}$/');
	public $yc      = array('code'=>'YC','name'=>'远长','reg_mail_no'=>'/^96[0-9]{12}$/');
	public $xb      = array('code'=>'XB','name'=>'新邦物流','reg_mail_no'=>'/[0-9]{8}/');
	public $sy      = array('code'=>'SY','name'=>'首业','reg_mail_no'=>'/^29[0-9]{8}$/');
	public $neda      = array('code'=>'NEDA','name'=>'港中能达','reg_mail_no'=>'/^((88|)[0-9]{10})$|^((1|2|3|5|)[0-9]{9})$/');
	public $qrt      = array('code'=>'QRT','name'=>'全日通快递','reg_mail_no'=>'/^[0-9]{12}$/');
	public $uc      = array('code'=>'UC','name'=>'优速物流','reg_mail_no'=>'/^VIP[0-9]{9}|V[0-9]{11}|[0-9]{12}$/');
	public $xfhong      = array('code'=>'XFHONG','name'=>'鑫飞鸿快递','reg_mail_no'=>'/^[0-9]{10,}$/');
	public $sto 	= array('code'=>'STO','name'=>'申通E物流','reg_mail_no'=>'/^(268|888|588|688|368|468|568|668|768|868|968)[0-9]{9}$|^(268|888|588|688|368|468|568|668|768|868|968)[0-9]{10}$|^(STO)[0-9]{10}$/');
	public $fast 	= array('code'=>'FAST','name'=>'快捷速递','reg_mail_no'=>'/^[0-9]{11,13}$/');
}


?>