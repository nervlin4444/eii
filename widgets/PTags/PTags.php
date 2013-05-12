<?php 

/*
 * PTags widget class file.
 
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:

 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.

 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.

 * PTags extends CWidget and implements a base class for a tag-managing widget.
 * more about Pines Tags can be found at http://pinesframework.org/ptags/
 * @version: 0.1
 */

class PTags extends CWidget
{

	// @ string the id of the widget
	public $id;
	// @ string the taget element on DOM
	public $value='';
	// @ array of options settings for fancybox
	public $options=array();
	// @ array used for simple option keys
	private $renamed_options=array();

	
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
    	
    	echo '<input type="text" id="Tags_'.$this->id.'" name="'.$this->id.'" value="'.$this->value.'" />';
		Yii::app()->clientScript->registerScript('PTags_'.$this->id, '
			$("#Tags_'.$this->id.'").ptags('.$this->buildOptions().');
		', CClientScript::POS_READY);
	}
	
	// function to publish and register assets on page 
	public function publishAssets()
	{
		$assets = dirname(__FILE__).'/assets/js';
		$baseUrl = Yii::app()->assetManager->publish($assets);

		if(is_dir($assets)){
			Yii::app()->clientScript->registerCoreScript('jquery');
			Yii::app()->clientScript->registerCssFile($baseUrl . '/jquery.ptags.default.css');
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/jquery.ptags.min.js', CClientScript::POS_HEAD);
		} else {
			throw new Exception('PTags - Error: Couldn\'t find assets to publish.');
		}
	}


    private function buildOptions() {

		$_default_options=array(
		'ptags_tags' => '',
		'ptags_current_text' => true,
		'ptags_delimiter' => ",",
		'ptags_trim_tags' => true,
		'ptags_show_box' => false,
		'ptags_input_box' => true,
		'ptags_remover' => true,
		'ptags_editable' => true,
		'ptags_sortable' => false,
		); 

    	foreach ($this->options as $key => $value) {
    		// check valid option
    		if (!array_key_exists('ptags_'.$key,$_default_options)) 
    			continue;	# unknown option

			if ($key == 'tags') {
				if (is_array($value))
					$this->renamed_options['ptags_'.$key] = $value;
					continue;
			}

			# just add option if not default
			if ($value != $_default_options['ptags_'.$key]) {
				$this->renamed_options['ptags_'.$key] = $value;
			}
    	}

        $options = CJavaScript::encode($this->renamed_options);
        return preg_replace ('#\s+#' , ' ' , $options);
    }

}



 ?>
