<?php

class LangSwitcherAC extends CApplicationComponent{

 	public $langs = array();
 	
 	public $flagname='lng';
 	
	/**
	 * Initializes the application component.
	 * This method is required by {@link IApplicationComponent} and 
	 * is invoked by application.
	 * If you override this method, make sure to call the parent implementation
	 * so that the application component can be marked as initialized.
	 */
	public /*/void/*/ function init(){
		if(empty($this->langs)){
		parent::init();
		array_push($this->langs,Yii::app()->getLanguage());}
		if(isset($_GET[$this->flagname]))
		$lang=$_GET[$this->flagname];
		//if not set any language return;
		if(!isset($lang))return;
		if($lang!=Yii::app()->getLanguage()&&in_array($lang,$this->langs))
		Yii::app()->setLanguage($lang);}

}	
?>