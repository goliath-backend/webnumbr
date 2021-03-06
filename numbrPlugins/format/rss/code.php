<?php
    $link = "http://webnumbr.com/" . htmlspecialchars(preg_replace("/.rss(\([^)]*\))?/", "", $c['code']));
?><?php print '<?xml version="1.0"?>' ?>
<rss version="2.0">
  <channel>
    <title><?php print htmlspecialchars($c['numbr']['title']) ?> - <?php print $c['code'] ?></title>
    <link><?php print $link ?></link>
    <description><?php print htmlspecialchars($c['numbr']['description']) ?></description>

<?php
if (!is_array($data)) {
    $data = array(strtotime($c['numbr']['modifiedTime']), $data);
}
$all = false;

if (is_array($param)) {
    foreach ($params as $key => $value) {
        if (!is_numeric($key)) continue;
        if (is_numeric($value))
            $params['count'] = $value;
        else if($value == "all")
            $params['all'] = TRUE;
    }
}

if (isset($params['count']))
    $count = (int) $params['count'];
if (isset($params['all'])) {
    switch (strtolower($params['all'])) {
        case 'true':
        case 't':
        case '1':
            $all = true;
    }
}

if (!is_numeric($count))
    $count = 10;

arsort($data);

$last = null;
foreach ($data as $row) {
    $time = $row[0];
    $value = $row[1];

    if ($value == null) continue;
    if (!$all && $value == $last) continue;

    if ($count-- <= 0) break;

    $last = $value;

    $permlink = $link . ".at($time)";
?>
 
    <item>
    <title><?php print htmlspecialchars($c['numbr']['title']) ?> @ <?php print date("ga, M j Y", $time); ?></title>
      <link><?php print $link ?></link>
      <description><?php print $value ?></description>
      <pubDate><?php print date(DATE_RFC822, $time) ?></pubDate>
      <guid isPermalink="false"><?php print $permalink ?></guid>
    </item>

<?php } ?>
  </channel>
</rss>
