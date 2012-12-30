<?php
/**
 * @(#)LangSwitcher.inc	1.0 02/02/11
 *
 * Copyright 2000-2011 Kevin Linz. All rights reserved.
 * Kevin Lin PROPRIETARY/CONFIDENTIAL. Use is subject to license terms.
 */
//===========================Package & Import==========================================\\
//---------------------------Base------------------------------------------------------\\
//---------------------------Development-----------------------------------------------\\
//---------------------------Resource--------------------------------------------------\\
/**
 * @author Kevin Linz <nerv_lin@yahoo.com.hk>
 * @todo Design Time
 * @version 1.0, 02/02/11
 * @since PHP6.0
 */
//===========================Code Start================================================\\
/*/public/*/ class LangSwitcher{
//===========================Class Constructor=========================================\\
//---------------------------Intermediate----------------------------------------------\\
//---------------------------Initialize------------------------------------------------\\
	/**
	 * Initializes the application component.
	 * This method is required by {@link IApplicationComponent} and 
	 * is invoked by application.
	 * If you override this method, make sure to call the parent implementation
	 * so that the application component can be marked as initialized.
	 */
	private static /*/LangSwitcher/*/ function getInstance(){
		if(isset(LangSwitcher::$instance))return LangSwitcher::$instance;
		if(empty(LangSwitcher::$availiableLangs)){
		LangSwitcher::$availiableLangs=array();
		LangSwitcher::$tagger="lng";
		array_push(LangSwitcher::$availiableLangs,Yii::app()->getLanguage());}
		$lang=Yii::app()->getRequest()->getParam(LangSwitcher::$tagger);
		if(isset($lang)&&$lang!=Yii::app()->getLanguage()&&
		in_array($lang,LangSwitcher::$availiableLangs))
		Yii::app()->setLanguage($lang);
		return LangSwitcher::$instance;}
//===========================Memory Locator============================================\\
//---------------------------Constant Class--------------------------------------------\\
//---------------------------Static Variable-------------------------------------------\\
	private static $instance;
	private static $availiableLangs;
	private static $tagger;
//---------------------------Instance Variable-----------------------------------------\\
//---------------------------Transient Variable----------------------------------------\\
//===========================Open Method===============================================\\
//---------------------------Memory Getter---------------------------------------------\\

	
	private static function getEnv($var){
		if(empty($_REQUEST[$var])){
		$_REQUEST[$var]=(!empty($_REQUEST['_SERVER'][$var]))? 
		$_REQUEST['_SERVER'][$var]:(!empty($_REQUEST['HTTP_SERVER_VARS'][$var]))? 
		$_REQUEST['HTTP_SERVER_VARS'][$var]:'';}} 

	public static function detect(){
		LangSwitcher::getInstance();
		// Detect HTTP_ACCEPT_LANGUAGE & HTTP_USER_AGENT. 
		getEnv('HTTP_ACCEPT_LANGUAGE'); 
		getEnv('HTTP_USER_AGENT'); 
		$_AL=strtolower($_REQUEST['HTTP_ACCEPT_LANGUAGE']); 
		$_UA=strtolower($_REQUEST['HTTP_USER_AGENT']); 
  
		foreach(LangSwitcher::_LANG as $K){ 
		if(strpos($_AL, $K)===0)return $K;} 
  
		foreach(LangSwitcher::_LANG as $K){ 
		if(strpos($_AL, $K)!==false)return $K;} 

		foreach(LangSwitcher::_LANG as $K){ 
		if(preg_match("/[[( ]{$K}[;,_-)]/",$_UA)) 
		return $K;} 
  
		return LangSwitcher::_DLANG;}

	// Define default language. 
	public $_DLANG='en'; 

		// Define all available languages. 
		// WARNING: uncomment all available languages 

	public $_LANG= array( 
//		'af', // afrikaans. 
//		'ar', // arabic. 
//		'bg', // bulgarian. 
//		'ca', // catalan. 
//		'cs', // czech. 
//		'da', // danish. 
//		'de', // german. 
//		'el', // greek. 
		'en', // english. 
//		'es', // spanish. 
//		'et', // estonian. 
//		'fi', // finnish. 
//		'fr', // french. 
//		'gl', // galician. 
//		'he', // hebrew. 
//		'hi', // hindi. 
//		'hr', // croatian. 
//		'hu', // hungarian. 
//		'id', // indonesian. 
//		'it', // italian. 
//		'ja', // japanese. 
//		'ko', // korean. 
//		'ka', // georgian. 
//		'lt', // lithuanian. 
//		'lv', // latvian. 
//		'ms', // malay. 
//		'nl', // dutch. 
//		'no', // norwegian. 
//		'pl', // polish. 
//		'pt', // portuguese. 
//		'ro', // romanian. 
//		'ru', // russian. 
//		'sk', // slovak. 
//		'sl', // slovenian. 
//		'sq', // albanian. 
//		'sr', // serbian. 
//		'sv', // swedish. 
//		'th', // thai. 
//		'tr', // turkish. 
//		'uk', // ukrainian. 
		'zh' // chinese. 
		); 
//---------------------------Interface Getter------------------------------------------\\
//---------------------------Memory Setter---------------------------------------------\\
//---------------------------Interface Setter------------------------------------------\\
//---------------------------Bounded Caller--------------------------------------------\\
//---------------------------Interacter------------------------------------------------\\
//---------------------------Interface Interacter--------------------------------------\\
//---------------------------Bean Override---------------------------------------------\\
//===========================Encapsulation Method======================================\\
//---------------------------Memory Initialize-----------------------------------------\\
//---------------------------Goey Initialize-------------------------------------------\\
//---------------------------Manipulate------------------------------------------------\\
//---------------------------Update----------------------------------------------------\\
//---------------------------Event-----------------------------------------------------\\
}//==========================Inner Class===============================================\\
//===========================Code End==================================================\\
?>