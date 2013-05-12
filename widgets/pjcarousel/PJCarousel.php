<?php

/*
 * PJCarousel widget class file.
 * @author Perochak(Muhammad Amjad) <me@perochak.com>
 * @link http://www.perochak.com
 * @licensed under both the MIT and GPL licenses.
 * @version: V1.0
 * @base on JCarousel
 
 Example:
 <ul id="foo"  class="jcarousel-skin-tango">
    <li> c </li>
    <li> a </li>
    <li> r </li>
    <li> o </li>
</ul>



// Using custom configuration
$this->widget('ext.pjcarousel.PJCarousel', array(
	'id' => 'foo',
        'skin'=>'tango',
        'config'=>array(
            'visible'=>8
        )
));


 */
class PJCarousel extends CWidget {
    public $id;
    public $config;
    public $skin='tango';
	// function to init the widget
	public function init()
	{
		// if not informed will generate Yii defaut generated id, since version 1.6
		if(!isset($this->id))
			$this->id=$this->getId();
		// publish the required assets
		$this->publishAssets();
	}
	// function to run the widget
        public function run()
        {
                    $config = CJavaScript::encode($this->config);
                    Yii::app()->clientScript->registerScript($this->getId(), "
                            $('#$this->id').jcarousel($config);
                    ");
            }   
	public function publishAssets()
	{
		$assets = dirname(__FILE__).'/assets';
		$baseUrl = Yii::app()->assetManager->publish($assets);
		if(is_dir($assets)){
			Yii::app()->clientScript->registerCoreScript('jquery');
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/jquery.jcarousel.js', CClientScript::POS_HEAD);
			Yii::app()->clientScript->registerCssFile($baseUrl . '/skins/'.$this->skin.'/skin.css');
                 }
	}            
}
?>
