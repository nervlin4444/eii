<style>
    #googleImageSearch {

    }
    #googleImageSearch .searchBox {
        padding:5px 8px;
        font-size:14px;
        font-size:13px;
        width:500px;
        margin:3px;
    }
    #googleImageSearch .btnSearch {
        padding:5px 8px;
        font-size:14px;
        font-weight:bold;
        font-size:15px;
    }
    #googleImageSearch .hint {
        color:#bbb;
    }
    #googleImageSearch .search-results {
        width:600px;
        min-height:130px;
        border:1px solid #eee;
        background:#fafafa;
        padding:10px;
    }
    #googleImageSearch .search-results .hint {
        font-size:13px;
        margin:5px;
    }
    #googleImageSearch .search-results img {
        border:4px solid #fff;
        margin:3px;
        -moz-box-shadow:    1px 1px 3px 3px #ccc;
        -webkit-box-shadow: 1px 1px 3px 3px #ccc;
        box-shadow:         1px 1px 3px 3px #ccc;
    }
    #googleImageSearch .search-info {
        width:602px;
        padding:2px 10px;
        font-size:13px;
        background:#ccc;
        color:#777;
        display:none;
    }
    #googleImageSearch .search-pages {
        float:right;
    }
    #googleImageSearch .search-pages .page {
        margin-right:3px;
        color:#888;
        cursor:pointer;
        padding:1px 4px;
    }
    #googleImageSearch .search-pages .page:hover {
        background:#fafafa;
        color:#333;
    }
    #googleImageSearch .search-preview {
        display:none;
    }
    #googleImageSearch .search-preview img {
        text-align:center;
        margin:10px;
        border:4px solid #fff;
        margin:20px;
        -moz-box-shadow:    1px 1px 3px 3px #ccc;
        -webkit-box-shadow: 1px 1px 3px 3px #ccc;
        box-shadow:         1px 1px 3px 3px #ccc;
    }
</style>
<script>
if (typeof jQuery == 'undefined') {
    alert("This example requires jQuery to be loaded..");
}
else {
    jQuery(function(){
        $("#googleImageSearch input.searchBox").focus();

        $("#googleImageSearch form.search-form").submit(function(e){
            e.preventDefault(); //do not send post

            var $googleImageSearch = $("#googleImageSearch");
            var $searchBox = $("input.searchBox", $googleImageSearch);
            var searchString = $searchBox.val();
            var page = $("input.searchPage",$googleImageSearch).val();
            var $resultsPlace = $(".search-results",$googleImageSearch);
            var $searchInfo = $(".search-info",$googleImageSearch);

            $resultsPlace.html( '<span class="hint">Loading..</span>' );
            $searchInfo.hide();

            if( searchString.length == 0 ) {
                // No search string given
                alert("Enter search string..");
                $searchBox.focus();
            }
            else {
                // Make search
                var url = "<?php echo Yii::app()->createUrl('imgSearch/ajaxSearch',array('q' => '')); ?>" + searchString + "&page="+page;
                $.getJSON( url, function(data) {
                    var $pageHolder = $(".search-pages",$googleImageSearch);
                    $pageHolder.text(''); //reset
                    $resultsPlace.text('No results');

                    if(! data) {

                        return false;
                    }
                    /*
                        data.responseStatus
                        data.responseData
                        data.responseData.results
                        data.responseData.cursor.resultCount
                    */
                    var items = [];


                    $.each(data.responseData.results, function(key, val) {
                        //console.log( val ); // see full info you get
                        items.push('<img src="'+val.tbUrl+'" alt="'+val.url+'" width="'+val.tbWidth+'" height="'+val.tbHeight+'" />');
                    });

                    // Show estimated count of results
                    $(".search-results-count",$googleImageSearch).text( data.responseData.cursor.resultCount );

                    // Make pages
                    var pages = data.responseData.cursor.pages;

                    $.each( pages , function(key, val) {
                        $pageHolder.append('<span class="page">'+val.label+'</span>');
                    });

                    $searchInfo.show();
                    $resultsPlace.html( items.join(" ") );
                });
            }
        });

        $(document).on("click", "#googleImageSearch .search-pages .page", function(){
            var $this = $(this);
            var $searchForm = $("#googleImageSearch form.search-form")
            var page = $this.text();

            $(".searchPage", $searchForm).val( page );
            $searchForm.submit();
        });

        $(document).on("click", "#googleImageSearch .search-results img", function(){
            var $this = $(this);
            var originalUrl = decodeURI($this.attr("alt"));
            $("#googleImageSearch .search-preview")
                .html('<img src="'+originalUrl+'" />')
                .hide()
                .fadeIn();

        });

    });
}
</script>
<?php

?>
<div id="googleImageSearch">
    <h1>Google Image search <sup class="hint">(jQuery)</sup></h1>
    <form class="search-form">
        <input type="input" class="searchBox" placeholder="Enter your search criteria.." />
        <input type="hidden" class="searchPage" value="1" />
        <input type="submit" value="Search" class="btnSearch" />
    </form>
    <div class="search-info">
        <b class="search-results-count"><!-- populated by js --></b> results
        <b class="search-pages"><!-- populated by js --></b>
    </div>
    <div class="search-results">
        <div class="hint">Search results will be laoded here</div>
        <!-- populate with javascript -->
    </div>
    <div class="search-info">
        <b class="search-results-count"><!-- populated by js --></b> results
        <b class="search-pages"><!-- populated by js --></b>
    </div>

    <div class="search-preview"></div>
</div>
