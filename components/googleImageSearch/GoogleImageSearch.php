<?php
/*
    https://developers.google.com/image-search/v1/jsondevguide#json_args
*/
class GoogleImageSearch extends CComponent {
    const SEARCH_BASE_URL = 'https://ajax.googleapis.com/ajax/services/search/images';
    public $cacheSec = 604800; //in seconds (604800s = 1week)
    public $webpage;
    private $urlParams = array();


    /**
    * Initialize the component.
    */
    public function init() {

    }

    // Mandatory url params
    private static function getMandatoryUrlParams() {
        return array(
            'v' => '1.0',
        );
    }

    // Add new param (or overwrite)
    public function setParam( $name, $value ) {
        $this->urlParams[ $name ] = $value;
    }

    // Remove specific param
    public function removeParam( $name ) {
        if( isset($this->urlParams[ $name ]) ) {
            unset( $this->urlParams[ $name ] );
        }
    }

    // Set new params (and clear old ones)
    public function setParams( $arr ) {
        $this->urlParams = $arr;
    }

    // Remove all user params
    // Leave default and mandatory
    public function clearParams() {
        $this->urlParams = array();
    }

    // Get all given params
    public function getUrlParams() {
        $paramsArr = $this->urlParams;

        // merge with mandatory
        $paramsArr = array_merge( self::getMandatoryUrlParams(), $paramsArr );
        return $paramsArr;
    }

    // Transform url params array to url params string
    private function getUrlParamsAsString() {
        $paramsArr = $this->getUrlParams();
        return http_build_query( $paramsArr );
    }

    // Make sure mandatory params is set
    // use default ones if not set
    private function checkParams( $userRelated = false ) {
        // Only user related
        if( $userRelated ) {
            // Is user ip set
            if(! isset($this->urlParams['userip']) ) {
                $this->urlParams['userip'] = Yii::app()->request->userHostAddress;
            }
        }
        // Not related to user
        else {
            // Is webpage set
            if(empty($this->webpage)) {
                $this->webpage = Yii::app()->request->hostInfo;
            }

            // Is start set
            if(! isset($this->urlParams['start'])) {
                $this->urlParams['start'] = 0;
            }

            // Is rsz (limit) set
            if(! isset($this->urlParams['rsz'])) {
                $this->urlParams['rsz'] = 8;
            }
        }
    }

    // Get results by given search term
    // (string) @q - given search term
    // @return object
    public function getResults( $q ) {
        $this->setParam('q', $q);
        $this->checkParams( false );

        // Make cache key before user related data
        $paramHash = md5( strtolower(str_replace(array(' ','+'),'', $this->getUrlParamsAsString())) );
        $cacheKey = 'ext.googleImageSearch.'.$paramHash;

        // Check user related params
        $this->checkParams( true );

        // Get actual results in JSON
        // connect to service OR use cache
        $jsonRaw =  Yii::app()->cache->get( $cacheKey );
        if( $jsonRaw === false ) {
            Yii::log( $this->getUrlParamsAsString(), 'error', 'PARAMS AFTER');
            $url = self::SEARCH_BASE_URL.'?'.$this->getUrlParamsAsString();

            // sendRequest
            // note how referer is set manually
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_REFERER, $this->webpage );
            $jsonRaw = curl_exec($ch);
            curl_close($ch);

            Yii::app()->cache->set($cacheKey,  $jsonRaw,  $this->cacheSec );
        }

        return $jsonRaw; // returns raw json data
    }

}
