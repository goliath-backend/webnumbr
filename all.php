<?php

require ("db.inc");
$stmt = $PDO->prepare("SELECT COUNT(name) as count FROM numbrs");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = (int) $data[0]['count'];

$subtitle = "All $count Numbrs";

function cutzero($value) {
   return preg_replace("/(\.?)0+$/", "", $value);
}

ob_start() ?> 
<h3 class="first">All <span id="number_of_numbrs"><?php print $count ?></span> Numbrs</h3> 
<div id='searchResults'> 
<ul class='searchresults'>
<?php
require("db.inc");
$stmt = $PDO->prepare("
SELECT 
    name, short(title, 100) as shorttitle, title, description, url, short(url, 100) as shorturl, is_fetching

FROM numbrs 

ORDER BY createdTime DESC
LIMIT :limit
");
if (isset($_REQUEST['limit'])) {
  $stmt->bindValue('limit', (int) $_REQUEST['limit'], PDO::PARAM_INT);
} else {
  $stmt->bindValue('limit', 1000000, PDO::PARAM_INT);
}
$stmt->execute() || die(json_encode($stmt->errorInfo()));
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <a href="/<?php print htmlspecialchars($row['name']) ?>" class="<?php print $row['is_fetching'] ? 'is_fetching' : 'is_not_fetching' ?>">
                  <?php print htmlspecialchars($data) ?>
                </a>
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
