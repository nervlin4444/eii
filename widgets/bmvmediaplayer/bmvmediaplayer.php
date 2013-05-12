
<?php
/**
 *
 * @version 0.1
 * @author b.vaghela05@gmail.com
 * @reference website  http://msdn.microsoft.com/en-us/library/aa917499.aspx
 *
 *
 */
class BmvMediaPlayer extends CWidget
{

	/** video path
	 * @var string
	 * @since 0.1
	 */
	public $src;
	
	/** video screen
	 * @var boolean
	 * @since 0.1
	 */
	
	public  $fullScreen =true;
	
	/** Video width
	 *
	 * @var integer
	 * @since 0.1
	 */
	
	public $width=360;
	
	public $showDisplay  = true;
	
	
	/**
	 * Boolean value specifying whether the control bar is visible. 
	 * If true, the control bar is visible. This property is read/write with a default value of true.
	 * @var boolean
	 * @since 0.1
	 */
	public $showControls = true;
	
	/**
	 * Boolean value specifying whether the status bar is visible. If true, the status bar is visible. 
	 * This property is read/write with a default value of false.
     * @var boolean
	 * @since 0.1
	 */
	
	public $showstatusBar = true;

	/** Video height
	 *
	 * @var integer
	 * @since 0.1
	 */
   	public $height=360;


	/**
	 *
	 * Boolean value indicating whether the Windows Media Player changes size to conform to the size of the content.
	 * If true, automatic sizing is enabled.
	 * If false, the Windows Media Player retains the width and height set at design time.
	 * See Remarks for default values.
	 *
	 * @var boolean
	 * @since 0.1
	 *
	 */
   	
	public $autoSize= true;

	/** AutoStart video on render
	 *
	 * @var boolean
	 * @since 0.1
	 */

	public $autoStart= true;

	/**
	 * This property specifies the stereo balance. This property is read/write.
	 * @var integer
	 * @since 0.1
	 *
	 */
	public $balance = 1;

	/**
	 * This property specifies the size of the image display window. This property is read/write.
	 * @var integer
	 * @since 0.1
	 */
	public $displaySize = 1;

	/**
	 * This property specifies the current mute state of the Windows Media Player control. This property is read/write.
	 * @var boolean
	 * @since 0.1
	 */

	public $mute = false;

	/**
	 * This property specifies the number of times a clip plays. This property is read/write.
	 * @var integer
	 * @since 0.1
	 */

	public $playCount = 0;
	
    /**
     * Double value specifying the clip's playback rate. 
     * This property is read/write with a default value of 1.0. 
   	 * @var float
	 * @since 1.0
     */
	
    public $rate;
    
    
	
	public $showAudioControls = true;
	public $showControl = true;
	public $showStatusBar = true;
	public $showTracker = true;
	public $stretchToFit = true;
	public $transparentAtStart = true;
	public $volume = 100;





	public function run()
	{
		//Get file
		//Check file codification, based on exists files extensions
		//create html output
		//render html
		echo $this->genHTMLcode();
	}

	/**
	 *  Generates html code that will be rendered in the view
	 *  Only generate html segments if encoded video files
	 * 
	 *
	 * @return string HTML Code
	 */
	private function genHTMLcode()
	{
		$autostart_ = 0;
		$autoSize_ = false;
		$mute_= 0;
		$showDisplay_ = 0 ;
		$showControls_ = 0;
		if($this->autoStart==true)
		{
			$autostart_ = 1;
			
		}
	   if($this->autoSize==1)
		{
			$autoSize_ = true;
			
		}
	   if($this->mute==true)
		{
			$mute_ = 1;
			
		}
		if($this->showDisplay==true)
		{
			$showDisplay_ = 1;
			
		}
	   if($this->showControls==true)
		{
			$showControls_ = 1;
			
		}
		
		?>
<object height="<?php echo $this->height; ?>" width="<?php echo $this->width; ?>" type="application/x-oleobject"
	standby="Loading Microsoft Windows Media Player components..."
	classid="CLSID:6BF52A52-394A-11D3-B153-00C04F79FAA6" id="MediaPlayer">
	<param
		value="<?php echo $this->src; ?>"
		name="Url">
	<param name="AutoSize"    value="<?php echo $this->autoSize; ?>">
	<param name="fullScreen"  value="<?php echo $this->fullScreen; ?>">
	<param name="AutoStart"   value="<?php echo $this->autoStart; ?>">
	<param name="Balance"     value="<?php echo $this->balance; ?>">
	<param name="DisplaySize" value="<?php echo $this->displaySize; ?>">
	<param name="Mute"        value="<?php echo $this->mute; ?>">
	<param name="PlayCount"   value="<?php echo $this->playCount; ?>">
	<param name="Rate"        value="<?php echo $this->rate; ?>">
	<param name="ShowAudioControls"  value="<?php echo $this->showAudioControls; ?>">
	<param name="ShowControls"       value="<?php echo $this->showControls; ?>">
	<param name="ShowDisplay"        value="<?php echo $this->showDisplay; ?>">
	<param name="ShowStatusBar"      value="<?php echo $this->showstatusBar; ?>">
	<param name="ShowTracker"        value="<?php echo $this->showTracker; ?>">
	<param name="StretchToFit"       value="<?php echo $this->stretchToFit; ?>">
	<param name="TransparentAtStart" value="<?php echo $this->transparentAtStart; ?>">
	<param value="<?php echo $this->volume; ?>" name="Volume">
	<embed height="<?php echo $this->height; ?>" width="<?php echo $this->width; ?>" volume="<?php echo $this->volume; ?>" transparentatstart="<?php echo $this->transparentAtStart; ?>"
		stretchtofit="<?php echo $this->stretchToFit; ?>" showtracker="1" showstatusbar="1" showdisplay="<?php echo $showDisplay_; ?>"
		showcontrols="1" showaudiocontrols="<?php echo $showControls_ ; ?>" rate="<?php echo $this->rate; ?>" playcount="<?php echo $this->playCount; ?>"
		mute="<?php echo $mute_; ?>" displaysize="<?php echo $this->displaySize; ?>" balance="<?php echo $this->balance; ?>" autostart="<?php echo $autostart_; ?>" autosize="<?php echo $autoSize_; ?>"
		fullScreen="<?php echo $this->fullScreen; ?>"
		src="<?php echo $this->src; ?>"
		pluginspage="http://www.microsoft.com/Windows/MediaPlayer"
		name="mediaplayer" type="application/x-mplayer2">

</object>


		<?php
	}


}


