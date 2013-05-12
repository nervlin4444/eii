<?php
/**
 * ETimePicker
 *
 *	Display a input box pair to receive a time from the user.
 *
 *	example usage:
 *	echo CHtml::hiddenField('mytimebox','23:59');
 *	$this->widget('ext.etimepicker.ETimePicker',array('altField'=>'mytimebox'));
 *
 * 
 * @uses CWidget
 * @author Christian Salazar H. <christiansalazarh@gmail.com> 
 * @license NEW BSD 
 *	Acarigua, Edo.Portuguesa, Venezuela, Dic2012.
 */
class ETimePicker extends CWidget {

	public $altField;

	private $_baseUrl;			// usada internamente para los assets

	public function init(){
		parent::init();
	}

	public function run(){
		$this->_prepareAssets();
		echo 
"
<div class='etimepicker' alt='{$this->altField}'>
	<input type='textbox' class='hour' size=3 maxlength=2 />
	<span class='sep'>:</span>
	<input type='textbox' class='minute' size=3 maxlength=2/>
	<select>
		<option value='am'>AM</option>
		<option value='pm'>PM</option>
	</select>
</div>
";
		$options = CJavaScript::encode(array(
		));
		Yii::app()->getClientScript()->registerScript("etimepicker_corescript"
				,"new ETimePicker({$options})");
	}// end run()

	public function _prepareAssets(){
		$localAssetsDir = dirname(__FILE__) . '/assets';
		$this->_baseUrl = Yii::app()->getAssetManager()->publish(
				$localAssetsDir);
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
		foreach(scandir($localAssetsDir) as $f){
			$_f = strtolower($f);
			if(strstr($_f,".swp"))
				continue;
			if(strstr($_f,".js"))
				$cs->registerScriptFile($this->_baseUrl."/".$_f);
			if(strstr($_f,".css"))
				$cs->registerCssFile($this->_baseUrl."/".$_f);
		}
	}
}
