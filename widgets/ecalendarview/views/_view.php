<?php
/**
 * _view.php
 *
 * @author Martin Ludvik <matolud@gmail.com>
 * @copyright Copyright &copy; 2013 by Martin Ludvik
 * @license http://opensource.org/licenses/MIT MIT license
 */
?>

<?php if($data->isRelevantDate): //sample ?>
  <?php $forecast = $this->getForecast($data->date); ?>
  <span style="font-size: 60%;"><?php echo $forecast['temperature']; ?></span> <br/>
  <span style="font-size: 60%;"><?php echo $forecast['conditions']; ?></span> <br/>
<? endif; //sample ?>

<?php echo CHtml::encode($data->date->format('j')); ?>

