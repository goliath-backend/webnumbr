<?php
session_start();
print '<?xml version="1.0" encoding="UTF-8"?>
';

// webnumbr is ...
$thoughts = array(
"like OMG the GREATEST thing in like EVER!!!!",
"superfly",
"adequate for my honored needs",
"like shooting a Winnebago over a crocodile pond",
"greater than e^(i \pi) - 1",
"<insert comment here>",
"horrible and should nev[CARRIER LOST]",
"in need of an urgent makeover",
);
$thought = $thoughts[rand(0, count($thoughts)-1)];

$status = urlencode("@webnumbr http://webnumbr.com is $thought");
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Web Numbr | <?php print $subtitle ?></title>
        <link rel="stylesheet" href="/style.css" type='text/css' />
        <meta name="keywords" content="webnumbr, webnumber, web number, web numbr, web graph, web plot, web grapher" />

        <meta property="og:type" content="website" />
        <meta property="og:title" content="<?php print $subtitle ?>" />
        <meta property="og:site_name" content="Webnumbr" />
        <meta property="og:image" content="http://webnumbr.com/images/webnumbr-logo-512.png" />
        <meta property="fb:app_id" content="130410460310483" /> 

        <?php print $htmlHead ?>
    </head>
    <body>
            <div id="wrap">
                <div id="header">
                    <div class="top-menu">
                        <ul>
                            <li>
<?php if (isset($_SESSION['openid'])){ ?>
                                <a href="/logout" title="You are <?php print htmlspecialchars($_SESSION['openid']) ?>">Log out</a>
<?php } else { 
    $next = 'http://' . $_SERVER['SERVER_NAME'] . '/rpx?_next=' . urlencode($_SERVER['REQUEST_URI']);
?>
                                <a id="login" class="rpxnow" onclick="return false;" href="https://webnumbr.rpxnow.com/openid/v2/signin?token_url=<?php print urlencode($next) ?>">Log In</a>
<?php } ?>
                            </li>
                            <li>
                                <a href="/create">Create</a>
                            </li>
                            <li>
                                <a href="/all">All</a>
                            </li>
                            <li>
                                <a href="/random">Random</a>
                            </li>
                            <li>
                                <a href="/api">API</a> 
                            </li>
                        </ul>
                        <form id="search_form" action="/search"> 
                            <div>
                                <input type="text" name="query" value="<?php print isset($current_search) ? $current_search : "" ?>" /> 
                                <input type="submit" value="Search " />
                            </div>
                        </form>
                    </div>
                    <span class="logo">
                        <a href='/'><img id='logopic' src="/images/webnumbr-banner-63.png" alt="logo" /></a>

<iframe src="http://www.facebook.com/plugins/like.php?href=http://webnumbr.com&amp;layout=button_count&amp;show_faces=false&amp;width=100&amp;action=like&amp;font&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px; margin-bottom: 10px; margin-left: 10px" allowTransparency="true"></iframe>

<?php if (substr($_SERVER['SERVER_NAME'], 0, 4) === "dev.") { ?>
                        <br/> <span style="color: red">Development version - <a href="http://twitter.com/webnumbr">File Bugs</a></span>
<?php } ?>

                    </span>
                    <div class="clear"></div>
                </div>
				<div id="content">
				<?php print $content ?>
				</div>
                    <div id="footer">
<?php if (isset($footer)) print $footer; ?>
                    </div>
            </div>
    
<script type="type/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript">
  var rpxJsHost = (("https:" == document.location.protocol) ? "https://" : "http://static.");
  document.write(unescape("%3Cscript src='" + rpxJsHost +
      "rpxnow.com/js/lib/rpx.js' type='text/javascript'%3E%3C/script%3E"));
  </script>
<script type="text/javascript">
  RPXNOW.overlay = true;
  RPXNOW.language_preference = 'en';
</script>
        <?php print isset($script) ? $script : "" ?>
        <?php include("ga.inc") ?>
        <?php include("uservoice.inc") ?>
        <?php include("woopra.inc") ?>

    </body>
</html>
