<?php
print '<?xml version="1.0" encoding="UTF-8"?>';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Web Grapher</title>
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/reset/reset-min.css" />
    <link rel="stylesheet" href="/style.css" type='text/css' />  
    <link rel="stylesheet" href="style.css" type='text/css' />  

    <link rel="icon" href="images/webGraphr-favicon.png" type="image/x-icon" />

    <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js'></script>
    <script type='text/javascript' src='http://plugins.jquery.com/files/jquery.query-2.1.2.js.txt'></script>
    <!--[if IE]><script type="text/javascript" src="js/flot/excanvas.pack.js"></script><![endif]-->
    <script type="text/javascript" src="js/flot/jquery.flot.js"></script>
    <script type="text/javascript" src='graph.js'></script>
    <style type="text/css">
html {
    margin : 0px;
    height : 100%;
    overflow : hidden;
}
body {
    height : 100%;
}

div#content {
    margin : auto;
    width : auto;
    vertical-align : middle;
    -moz-border-radius : 0px;
    -webkit-border-radius : 0px;
    height : 100%;
}

h5 {
    margin : 0px;
    text-decoration : underline;
}
    </style>
  </head>
  <body>
    <h5 id='title'></h5>
    <div id="content">
        <div id="plot" class='center'>/\___|\___/\</div>
    </div>
    <script>
if (typeof paulisageek == "undefined") { paulisageek = {}; }
if (typeof paulisageek.wg == "undefined") { paulisageek.wg = {}; }

paulisageek.wg.preGraphCallback = function(json) {
    console.log($("#content").innerHeight());
    console.log($("#title").outerHeight(true));
    $("#plot").height(($("#content").innerHeight() - 40));
    $("#plot").width(($("#content").width() - 40));
}
paulisageek.wg.postGraphCallback = function(json) {
    $("#title").ready(function() {
        var keys = $.query.keys;
        delete keys.type;
        $("#title").wrap('<a target="_new" href="http://paulisageek.com/webGraphr/graph.php?' + $.param(keys) + '"></a>"');
    });
}
    </script>
  </body>
</html>
