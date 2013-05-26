<?php

class ImageSearchController extends CExtController {

    // Make search call
    public function actionAjaxSearch() {

        $searchString = Yii::app()->request->getParam('q');
        $page = Yii::app()->request->getParam('page', 1);
        $limit = Yii::app()->request->getParam('limit', 8); //results per page

        $imgSearch = Yii::app()->imgSearch;

        // All possible params:
        // https://developers.google.com/image-search/v1/jsondevguide#json_args
        $imgSearch->setParams(array(
            'start' => ($page * $limit) - $limit, // start at zero at firs page
            'rsz' => $limit,
            'hl' => Yii::app()->language,
            //'as_filetype' => 'png', //default to all types
        ));

        //$imgSearch->userIp = Yii::app()->request->userHostAddress;
        //// https://developers.google.com/image-search/v1/jsondevguide#json_args
        //$imgSearch->setParam('hl',Yii::app()->language);
        //$imgSearch->setParam('start', ($page * $limit) - $limit); //start at zero at firs page
        //$imgSearch->setParam('rsz', $limit);
        //$imgSearch->setParam('as_filetype','png');

        $jsonRaw = $imgSearch->getResults( $searchString );
        $json = json_decode( $jsonRaw );

        //dbg( $imgSearch->getMetaData() );

        if(! $json->responseData->results ) {
            appEnd();
        }

        //echo CJSON::encode( $json );
        echo $jsonRaw;

        appEnd();

    }

    //
    public function actionSearch() {
        $this->render('search');
    }

}
