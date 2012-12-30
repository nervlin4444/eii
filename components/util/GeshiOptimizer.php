<?php
/**
 * @(#)GeshiOptimizer.inc	1.0 02/02/11
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
//===========================Geshi Start================================================\\
/*/public/*/ class GeshiOptimizer{
//===========================Class Constructor=========================================\\
//---------------------------Intermediate----------------------------------------------\\
//---------------------------Initialize------------------------------------------------\\
	private static /*/GeshiOptimizer/*/ function getInstance(){
		if(isset(GeshiOptimizer::$instance))return GeshiOptimizer::$instance;
		GeshiOptimizer::$cmp=new CMarkdownParser();
		return GeshiOptimizer::$instance;}
//===========================Memory Locator============================================\\
//---------------------------Constant Class--------------------------------------------\\
//---------------------------Static Variable-------------------------------------------\\
	private static $instance;
	private static $geshi;
	private static $cmp;
//---------------------------Instance Variable-----------------------------------------\\
//---------------------------Transient Variable----------------------------------------\\
//===========================Open Method===============================================\\
//---------------------------Memory Getter---------------------------------------------\\
//---------------------------Interface Getter------------------------------------------\\
//---------------------------Memory Setter---------------------------------------------\\
//---------------------------Interface Setter------------------------------------------\\
//---------------------------Bounded Caller--------------------------------------------\\
//---------------------------Interacter------------------------------------------------\\
	public static /*/String/*/ function pasreByGeSHi($path){
		GeshiOptimizer::getInstance();
		$ext=substr($path,strrpos($path,".")+1);
		if($ext=='inc')$ext='php';
		$doc=file_get_contents($path);
		$geshi=new GeSHi($doc,$ext);
		return GeshiOptimizer::$cmp->safeTransform($geshi->parse_Geshi());}
	
	public static /*/String/*/ function pasreByGeSHiSofty($path){
		$ext=substr($path,strrpos($path,".")+1);
		if($ext=='inc')$ext='php';
		$geshi=new GeSHi('',$ext);
		/*
		 * Sets whether a particular $group of keywords is to be highlighted or not.
		 * Consult the necessary language file(s) to see what $group should be 
		 * for each group (typically a positive integer). 
		 * $flag is false if you want to disable highlighting of this group, 
		 * and true if you want to re-enable higlighting of this group. 
		 * If you disable a keyword group then even if the keyword group has 
		 * a related URL one will not be generated for that keyword.
		 */
		$geshi->set_keyword_group_highlighting($group, false);
		/*
		 * Sets whether a particular $group of comments is to be highlighted or not. 
		 * Consult the necessary language file(s) to see what $group should be 
		 * for each group (typically a positive integer, 
		 * or th string 'MULTI' for multiline comments. 
		 * $flag is false if you want to disable highlighting of this group, 
		 * and true if you want to re-enable highlighting of this group.
		 */
		$geshi->set_comments_highlighting($group, false);
		/*
		 * Sets whether a particular $regexp is to be highlighted or not. 
		 * Consult the necessary language file(s) to see what $regexp should be 
		 * for each regexp (typically a positive integer, 
		 * or the string 'MULTI' for multiline comments. 
		 * $flag is false if you want to disable highlighting of this group, 
		 * and true if you want to re-enable highlighting of this group.
		 */
		$geshi->set_regexps_highlighting($regexp, false);
		/*
		 * The following methods Work on their respective lexics
		 */
		if(strlen($doc)>10000){
		$geshi->set_escape_characters_highlighting(false);
		$geshi->set_symbols_highlighting(false);
		$geshi->set_strings_highlighting(false);
		$geshi->set_numbers_highlighting(false);
		$geshi->set_methods_highlighting(false);}
		$doc=file_get_contents($path);
		if(strlen($doc)>10000)
		$doc=call_user_func(array($this,"splitStrlen"),$doc);
		else 
		$doc=call_user_func(array($this,"splitNone"),$doc);
		for($i=0;$i<count($doc);$i++){
		$geshi->set_source($doc[$i]);
		$doc[$i]=$geshi->parse_Geshi();}
		$doc=implode("",$doc);
		$doc=str_replace(
		'</pre><pre class="'.$ext.'" style="font-family:monospace;">',"",$doc);
		return GeshiOptimizer::$cmp->safeTransform($doc);}
//---------------------------Interface Interacter--------------------------------------\\
//---------------------------Bean Override---------------------------------------------\\
//===========================Encapsulation Method======================================\\
//---------------------------Memory Initialize-----------------------------------------\\
//---------------------------Goey Initialize-------------------------------------------\\
//---------------------------Manipulate------------------------------------------------\\
	/*
	 *@incubation 
	 */
	private static /*/String[]/*/ function split_function($doc){
		$arr=preg_split("/ function /",$doc,null,PREG_SPLIT_NO_EMPTY);
		for($i=0;$i<count($arr);$i++)
		$arr[$i]=' function '.$arr[$i];
		return $arr;}
	/*
	 *@incubation 
	 */
	private static /*/String[]/*/ function splitNone($doc){
		return array($doc);}
	/*
	 *@incubation 
	 */
	private static /*/String[]/*/ function splitStrlen($doc){
		return str_split($doc,strlen($doc)/10);}
	
//---------------------------Update----------------------------------------------------\\
//---------------------------Event-----------------------------------------------------\\
}//==========================Inner Class===============================================\\
//===========================Geshi End==================================================\\
?>