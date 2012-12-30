<?php
  // @version $Id$

class AnalogueClock extends CPortlet
{
	public $title='Clock';
	
	private $baseUrl=null;

	public function init()
	{
		parent::init();
		Yii::app()->clientScript->registerCoreScript('jquery');
		
		$assets = dirname(__FILE__).'/image';
		$this->baseUrl = Yii::app()->assetManager->publish($assets);

		$script="
		$(document).ready(function() {
			var left = $('.clock_window').width()/2-104/2;
			$('.hourHand').css('left', left+'px');
			$('.minuteHand').css('left', left+'px');
			$('.secondHand').css('left', left+'px');
			var top = $('.clock_window').height()/2-104/2;
			$('.hourHand').css('top', top+'px');
			$('.minuteHand').css('top', top+'px');
			$('.secondHand').css('top', top+'px');
			animation();
			setInterval(function(){
				animation();
			}, 1000);
			function animation() {
				var currentTime = new Date();
				var s = currentTime.getSeconds();
				var m = currentTime.getMinutes();
				var h = Math.floor(5*(currentTime.getHours()%12)+m/12);
				$('.hourHand').css('background-position', -h*104+'px 0px');
				$('.minuteHand').css('background-position', -m*104+'px -104px');
				$('.secondHand').css('background-position', -s*104+'px -208px');
			}
		});
		";
		
		Yii::app()->clientScript->registerScript(__CLASS__,$script,CClientScript::POS_END);
		
		
	}

	protected function renderContent()
	{
		$this->render('analogue-clock',array(
				'baseUrl'=>$this->baseUrl,
				));
	}
}
