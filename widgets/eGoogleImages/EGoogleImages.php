<?php

class EGoogleImages extends CWidget {

    public $q;
    public $size = 3;
    public $safeSearch = false;
    private $baseUrl;

    private function prepareQuery() {

        $this->q = preg_replace("/\([^\)]+\)/", "", $this->q);
        $this->q = preg_replace("/\[[^\]]+\]/", "", $this->q);
        return $this->q;
    }

    public function init() {

        parent::init();

        $assets = dirname(__FILE__) . '/assets';
        $this->baseUrl = Yii::app()->assetManager->publish($assets);

        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerCSSFile($this->baseUrl . '/css/style.css')
                ->registerScriptFile($this->baseUrl . '/js/jquery.jsonp.js', CClientScript::POS_END);

        return;
    }

    public function run() {

        $cs = Yii::app()->clientScript;

        $js = 'function process'.$this->id.'Results(data) {
            
                if(data && data.responseData){
                    var container = $("#' . $this->id . '_container").html("");
                        $(data.responseData.results).each(function(){
                            //console.log(this);
                            container.append($("<img>").attr("src", this.tbUrl));
                        });
                }
            
        } ' . PHP_EOL;

        $cs->registerScript(__CLASS__ . $this->getId() . 'head', $js, CClientScript::POS_HEAD);

        $url = 'http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=' . urlencode($this->prepareQuery()) . '&start=0' . ($this->safeSearch ? '' : '&safe=off') . '&rsz=' . $this->size . '&callback=process'.$this->id.'Results';
        $js = '$.jsonp(' . CJavaScript::encode(array(
                    'url' => $url,
                )) . ')';

        $cs->registerScript(__CLASS__ . $this->getId(), $js, CClientScript::POS_READY);

        echo CHtml::tag('div', array('id' => $this->id . '_container'), 'querying images...');
    }

}