<?php
$connectionString = "mysql:host=localhost;dbname=travel";
$user = "root";
$pass = "";
try {
  $pdo = new PDO($connectionString, $user, $pass);
} catch (PDOException $e) {
  die($e->getMessage());
}
function getImagesArray()
{
  global $pdo;
  $sql = "SELECT Title,Path,ImageID FROM imagedetails";
  $countrySet = isset($_GET['country']) && $_GET['country'] != "0";
  $continentSet = isset($_GET['continent']) && $_GET['continent'] != "0";
  $titleSet = isset($_GET['title']) && $_GET['title'] != "";
  if ($countrySet || $continentSet || $titleSet) {
    $country = $_GET['country'];
    $continent = $_GET['continent'];
    $title = $_GET['title'];
    $sql .= " WHERE ";
    if ($titleSet) {
      if ($countrySet)
        $sql .= " CountryCodeISO='$country' AND ";
      elseif ($continentSet)
        $sql .= " ContinentCode='$continent' AND ";
      $sql .= " Title LIKE '%$title%'";
    } elseif ($countrySet)
      $sql .= " CountryCodeISO='$country'";
    else
      $sql .= " ContinentCode='$continent' ";
  }
  $result = $pdo->query($sql);
  $images = $result->fetchAll();
  return $images;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Chapter 14</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

  <link rel="stylesheet" href="css/bootstrap.min.css"/>


  <link rel="stylesheet" href="css/captions.css"/>
  <link rel="stylesheet" href="css/bootstrap-theme.css"/>

</head>

<body>
<?php include 'header.inc.php'; ?>

<!-- Page Content -->
<main class="container">
  <div class="panel panel-default">
    <div class="panel-heading">Filters</div>
    <div class="panel-body">
      <form action="Lab10.php" method="get" class="form-horizontal">
        <div class="form-inline">
          <select name="continent" class="form-control" title="continent">
            <option value="0">Select Continent</option>
            <?php
            $sql = "SELECT ContinentCode,ContinentName FROM continents ORDER BY ContinentName";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()) {
              echo '<option value=' . $row['ContinentCode'] . '>' . $row['ContinentName'] . '</option>';
            }
            ?>
          </select>
          <select name="country" class="form-control" title="country">
            <option value="0">Select Country</option>
            <?php
            $sql = "SELECT ISO, CountryName FROM countries ORDER BY CountryName";
            $result = $pdo->query($sql);
            while ($row = $result->fetch()) {
              echo '<option value=' . $row['ISO'] . '>' . $row['CountryName'] . '</option>';
            }
            ?>
          </select>
          <input type="text" placeholder="Search title" class="form-control" name="title">
          <button type="submit" class="btn btn-primary">Filter</button>
        </div>
      </form>
    </div>
  </div>
  <ul class="caption-style-2">
    <?php
    $imagesArray = getImagesArray();
    for ($i = 0; $i < count($imagesArray); $i++) {
      $Path = $imagesArray[$i]['Path'];
      $ImageID = $imagesArray[$i]['ImageID'];
      $Title = $imagesArray[$i]['Title'];
      echo '<li>';
      echo "<a href=\"detail.php?id=$ImageID\" class=\"img-responsive\">";
      echo "<img src=\"images/square-medium/$Path\" alt=\"$Title\">";
      echo "<div class=\"caption\">";
      echo "<div class=\"blur\"></div>";
      echo "<div class=\"caption-text\">";
      echo "<p>$Title</p>";
      echo "</div>";
      echo "</div>";
      echo "</a>";
      echo "</li>";
    }
    ?>
  </ul>
</main>
<footer>
  <div class="container-fluid">
    <div class="row final">
      <p>Copyright &copy; 2017 Creative Commons ShareAlike</p>
      <p><a href="#">Home</a> / <a href="#">About</a> / <a href="#">Contact</a> / <a href="#">Browse</a></p>
    </div>
  </div>
</footer>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
</body>
</html>