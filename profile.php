<?php
$current_search = htmlspecialchars($_REQUEST['name']);
$subtitle = "search : " . htmlspecialchars($_REQUEST['name']);

function cutzero($value) {
   return preg_replace("/(\.?)0+$/", "", $value);
}

?>
<?php ob_start() ?>
        <h3 class="first">Numbrs made by <tt><?php print $current_search ?></tt></h3>

        <div id='searchResults'>
          <ul class='searchresults'>
<?php
require("db.inc");
$stmt = $PDO->prepare("
SELECT 
    name, short(title, 100) as shorttitle, title, description, url, short(url, 100) as shorturl

FROM numbrs WHERE

openid LIKE CONCAT('%', :query, '%')

ORDER BY createdTime DESC
");
$stmt->execute(array("query" => $_REQUEST['name'])) || die(json_encode($stmt->errorInfo()));
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($data) == 0) {
    print '0 results. Try <a class="external" href="http://google.com/search?q=' . urlencode("site:webnumbr.com " . htmlentities($_REQUEST['name'])) . '">google</a>?';
}

foreach ($data as $row) {
    $sd = $PDO->prepare("
SELECT 
    data

FROM numbr_data WHERE

numbr = :name

ORDER BY timestamp DESC
");
    $sd->execute(array("name" => $row['name'])) || die(json_encode($stmt->errorInfo()));
    $data = $sd->fetchAll(PDO::FETCH_ASSOC);
    $data = $data[0]['data'];
    if (trim($data) == "") continue;
    $data = cutzero(number_format($data, 4, ".", ","));
?>
        <li>
            <div class="search_data">
                <a href="/<?php print htmlspecialchars($row['name']) ?>"><?php print htmlspecialchars($data) ?></a>
            </div>
            <div class="search_title">
                <a href="/<?php print htmlspecialchars($row['name']) ?>" title="<?php print htmlspecialchars($row['title'])?>">
                    <?php print ($row['shorttitle'] == "" ? "&nbsp;" : htmlspecialchars($row['shorttitle'])) ?>
                </a>
            </div>
            <div class="search_url">
                <a href="<?php print htmlspecialchars($row['url']) ?>" title="<?php print htmlspecialchars($row['url'])?>">
                    <?php print htmlspecialchars($row['shorturl']) ?>
                </a>
            </div>
       </li>
<?php
}
?>
          </ul>
        </div>

      </div>
<?php $content = ob_get_clean(); require("template.php"); ?>
