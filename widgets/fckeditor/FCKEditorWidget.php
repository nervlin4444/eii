<?php
/* 
 * Editor widget - both for Tiny_vce and FCKeditor
 *
 * usage sample:
 *  echo CHtml::activeTextArea($post,'content',array('rows'=>6, 'cols'=>60));
 *  $this->widget('application.extensions.editor.editor',
 *                   array('name'=>'post_content', ));
 *
 * Common properties:
 *  - type: tinymce/fckeditor, may be set in config/main params as Yii::app()->params['editor']
 *  - name: required(!!!) field name for textarea
 *  - heigth (optional)
 *  - toolbar (optional)
 *
 * Tiny_mce properties:
 *  - language (optional, default: App setting)
 *      required additional language download from official site
 *  - date_format (optional)
 *  - time_format (optional)
 */

class FCKEditorWidget extends CInputWidget
{
    public $name;
    public $type;
    public $toolbar;
    public $language;
    public $height = '300';
    public $width = '100%';
    public $date_format = "%Y-%m-%d";
    public $time_format = "%H:%M:%S";
    protected $path;

    public function init()
    {
        if(!isset($this->name)) throw new CHttpException(500,'Input field name for "tiny_mce" have to be set!');
        if(!isset($this->type)) $this->type = Yii::app()->params['editor'];
        if(!isset($this->toolbar)){
            if($this->type == 'fckeditor'){
                $this->toolbar = 'Default';
            }else {
                $this->toolbar = 'advanced';
            }
        }
        if($this->type === 'tinymce'){
            $this->path = Yii::app()->getAssetManager()->publish(dirname(__FILE__).DIRECTORY_SEPARATOR."tiny_mce");
        }else{
            $this->path = Yii::app()->getAssetManager()->publish(dirname(__FILE__).DIRECTORY_SEPARATOR."fckeditor");
        }    
			// change recursively file chmod
			//chmod(Yii::app()->getAssetManager()->getPublishedPath(dirname(__FILE__).DIRECTORY_SEPARATOR."fckeditor")."/", 0755 );
            //$this->recursiveChmod(Yii::app()->getAssetManager()->getPublishedPath(dirname(__FILE__).DIRECTORY_SEPARATOR."fckeditor"));
			 
        if(!isset($this->language)) $this->language = Yii::app()->language;
        parent::init();
    }
    
   private function recursiveChmod($path, $filePerm=0644, $dirPerm=0755)
   {
      // Check if the path exists
      if(!file_exists($path))
      {
         return(FALSE);
      }
      // See whether this is a file
      if(is_file($path))
      {
         // Chmod the file with our given filepermissions
         chmod($path, $filePerm);
      // If this is a directory...
      } elseif(is_dir($path)) {
         // Then get an array of the contents
         $foldersAndFiles = scandir($path);
         // Remove "." and ".." from the list
         $entries = array_slice($foldersAndFiles, 2);
         // Parse every result...
         foreach($entries as $entry)
         {
            // And call this function again recursively, with the same permissions
            $this->recursiveChmod($path."/".$entry, $filePerm, $dirPerm);
         }
         // When we are done with the contents of the directory, we chmod the directory itself
         chmod($path, $dirPerm);
      }
      // Everything seemed to work out well, return TRUE
      return(TRUE);
   }


    public function run()
    {
    
        $this->render($this->type, array(
                'name'=>$this->name,
                'toolbar'=>$this->toolbar,
                'language'=>$this->language,
                'height'=>$this->height,
                'width'=>$this->width,
                'date_format'=>$this->date_format,
                'time_format'=>$this->time_format,
                'path'=>$this->path,
                'publishPath' => Yii::app()->getAssetManager()->getPublishedPath(dirname(__FILE__).DIRECTORY_SEPARATOR."fckeditor")
            ));
    }
}
?>
