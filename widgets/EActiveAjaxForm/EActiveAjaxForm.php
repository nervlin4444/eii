<?php

/**
* EActiveAjaxForm class file.
* 
* for using ajax validation + ajaxSubmitButton together in CActiveForm . 
* 
* @author Huabin <hehbhehb@sina.com>
*/

/**
 * CActiveForm ajax validation works does not work at all when you use ajaxSubmitButton in the form, instead of SubmitButton.
 * The issue is discussed here - http://code.google.com/p/yii/issues/detail?id=2008
 * We have to merge the both actions into one, either append ajaxSubmitButton after validation code, or append validation code before ajaxSubmitButton  
 * I prefer to the previous, it is more simple, for we just need prepare appropriate afterValidate option. 
 *
 * Sample:
	<?php $form=$this->beginWidget('EActiveAjaxForm', array(
		'id'=>'form_id',
		'clientOptions' => array(
			'validateOnSubmit'=>true,
			'validateOnChange'=>false,
		),
		'ajaxSubmitOptions' => array('success' => 'js:function() {alert("Success");}', 'error' => 'js:function() {alert("error");}'),
		'action' => CHtml::normalizeURL(array('user/create')),
	));	?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'name'); ?>		<!-- note: MUST have at least one $form->error() tag in the form, otherwise have not ajax validation and ajax submit! -->
	</div>

	<?php echo CHtml::submitButton('Save'); ?>
	<?php $this->endWidget(); ?>
*
*
*/

class EActiveAjaxForm extends CActiveForm
{
	/**
	 * @var array the options to be passed to the javascript ajax submit form action.
	 * most ajax options in CHtml::ajaxSubmitButton() can be supported here
	 * note: if the validation is not passed, submit action will be canceled.
	 */
	public $ajaxSubmitOptions = array();

	public function init()
	{
		parent::init();

		$this->enableAjaxValidation = true;
		$this->clientOptions['validateOnSubmit'] = true;
		$this->ajaxSubmitOptions['type'] = 'POST';
		$this->ajaxSubmitOptions['url'] = $this->action;
		$this->ajaxSubmitOptions['data']=new CJavaScriptExpression('form.serialize() + extData');

		$handler = CHtml::ajax($this->ajaxSubmitOptions);
		$this->clientOptions['afterValidate'] = 
			"js:function(form, data, hasError) {
				if (!hasError) {
					var button = form.data('submitObject');
					extData = '';
					if (button && button.length) {
						extData = '&' + button.attr('name') + '=' + button.attr('value');
					}
					{$handler}
				}
				return false;
             }";
	}

}


