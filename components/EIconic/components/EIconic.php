<?php

/**
 * EFontAwesome loader class file.
 * @author Jorge Mariani <jorgemariani@gmail.com>
 * @license http://creativecommons.org/licenses/by-sa/3.0/
 * Iconic - http://somerandomdude.com/work/iconic/
 */

class EIconic extends CApplicationComponent {

    protected $_assetsUrl;

    /**
     * Initializes the component.
     */
    public function init() {
        if (Yii::getPathOfAlias('eiconic') === false)
            Yii::setPathOfAlias('eiconic', realpath(dirname(__FILE__) . '/..'));

        // Prevents the extension from registering scripts and publishing assets when ran from the command line.
        if (Yii::app() instanceof CConsoleApplication)
            return;
        Yii::app()->getClientScript()->registerCssFile($this->getAssetsUrl() . "/css/iconic.css"); //, $media);

        parent::init();
    }

    /**
     * Returns the URL to the published assets folder.
     * @return string the URL
     */
    public function getAssetsUrl() {
        if (isset($this->_assetsUrl))
            return $this->_assetsUrl;
        else {
            $assetsPath = Yii::getPathOfAlias('eiconic.assets');
            $assetsUrl = Yii::app()->assetManager->publish($assetsPath, false, -1, YII_DEBUG);
            return $this->_assetsUrl = $assetsUrl;
        }
    }
}
