This is a simple widget for your form, whenever you need to get a time from your user, you can insert multiple ETimePicker widgets on the same form. It uses jQuery.

Author:
**Christian Salazar (bluyell)**, <christiansalazarh@gmail.com>

[http://www.yiiframeworkenespanol.org/wiki](http://www.yiiframeworkenespanol.org/wiki "http://www.yiiframeworkenespanol.org/wiki")

##Screenshot

![Screenshot for ETimePicker](https://bitbucket.org/christiansalazarh/etimepicker/downloads/ETimePicker.png "Screenshot for ETimePicker")

##Requirements

Yii 1.1.12
jQuery.

##Usage

In your view:
~~~
	echo $form->hiddenField($model,'yourtimefield');
	$this->widget('ext.etimepicker.ETimePicker',
		array('altField'=>'YourModel_yourtimefield'));  // the input ID !
	echo $form->error($model,'yourtimefield');
~~~

Your sample model:
~~~
class YourModel extends CFormModel /*or CActiveRecord !*/ {
  public $yourtimefield;  // a time field: "hh:mm" formatted (24 hours)
  ...
}
~~~