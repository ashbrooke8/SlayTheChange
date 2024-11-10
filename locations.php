<?php
$csvFile = 'new_locations.csv';
$locations = [];

$searchTerm = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';
$selectedTags = isset($_GET['tags']) && is_array($_GET['tags']) ? $_GET['tags'] : [];

if (($handle = fopen($csvFile, "r")) !== false) {
  $header = fgetcsv($handle);
  while (($row = fgetcsv($handle)) !== false) {
    if (count($header) != count($row)) {
      continue;
    }

    $location = array_combine($header, $row);

    $locationType = strtolower($location['type']);
    $locationName = strtolower($location['name']);
    $matchesSearchTerm = empty($searchTerm) ||
      stripos($locationName, $searchTerm) !== false ||
      stripos($locationType, $searchTerm) !== false;

    $matchesTags = empty($selectedTags) || array_reduce($selectedTags, function ($carry, $tag) use ($location) {
      return $carry && stripos($location['tags'], $tag) !== false;
    }, true);

    if ($matchesSearchTerm && $matchesTags) {
      $locations[] = $location;
    }
  }
  fclose($handle);
}

$imageMap = [
  '1' => 'images/locations/starbucks.jpg',
  '2' => 'images/locations/second-cup.jpg',
  '3' => 'images/locations/urban-outfitters.jpg',
  '4' => 'images/locations/thewomenscollectivebotique.jpg',
  '5' => 'images/locations/happybean.jpg',
  '6' => 'images/locations/ecogrocers.jpg',
  '7' => 'images/locations/peacefulminds.png',
  '8' => 'images/locations/thegreenplanet.jpg',
  '9' => 'images/locations/openheartcafe.jpg',
  '10' => 'images/locations/planetthrift.jpg',
  '11' => 'images/locations/dynamite.jpg',
  '12' => 'images/locations/hm.jpg',
  // '13' => 'images/locations/zara.jpg',
  // '14' => 'images/locations/goodwill.jpg',
  // '15' => 'images/locations/safeway.jpg',
  // '16' => 'images/locations/naturesbasket.jpg',
  // '17' => 'images/locations/thegreenmarket.jpg',
  // '18' => 'images/locations/budgetgrocers.jpg',
  // '19' => 'images/locations/rainbowfoods.jpg',
  // '20' => 'images/locations/bostonpizza.jpg',
  // '21' => 'images/locations/vegandelights.jpg',
  // '22' => 'images/locations/happydiner.jpg',
  // '23' => 'images/locations/rainboweatery.jpg',
  // '24' => 'images/locations/dennys.jpg',
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Location Results</title>
  <link rel="stylesheet" href="css/results.css">

</head>

<body>
  <nav>
    <div id="logo-container">
      <a href="index.html"><img src="images\logo.png" alt="logo" id="logo"></a>
      <a href="index.html" id="site-name">Hidden Havens</a>
    </div>
    <form method="get" action="locations.php" id="search-form">
      <input type="search" name="search" placeholder="Search (e.g. Cafe, Clothing Store)..." id="search-bar"
        value="<?php echo htmlspecialchars($searchTerm); ?>">
      <button type="submit" id="search-button">Search</button>
    </form>
    <!-- <button id="login-button" href="login.html">Log In</button> -->
    <a id="login-button" href="login.html">Login</a>
  </nav>

  <div class="content-box">
    <div class="filter-area">
      <p id="filter-results">Filter Results</p>
      <form method="get" action="locations.php" id="filter-form">
        <input type="hidden" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>">

        <label>
          <input type="checkbox" name="tags[]" value="Women-Centered" <?php echo in_array('Women-Centered', $selectedTags) ? 'checked' : ''; ?>>
          Women-Centered
        </label>

        <label>
          <input type="checkbox" name="tags[]" value="LGBTQ+" <?php echo in_array('LGBTQ+', $selectedTags) ? 'checked' : ''; ?>>
          LGBTQ+
        </label>

        <label>
          <input type="checkbox" name="tags[]" value="Accessible" <?php echo in_array('Accessible', $selectedTags) ? 'checked' : ''; ?>>
          Accessible
        </label>

        <label>
          <input type="checkbox" name="tags[]" value="Body Positive" <?php echo in_array('Body Positive', $selectedTags) ? 'checked' : ''; ?>>
          Body Positive
        </label>

        <label>
          <input type="checkbox" name="tags[]" value="All-Gender Bathrooms" <?php echo in_array('All-Gender Bathrooms', $selectedTags) ? 'checked' : ''; ?>>
          All-Gender Bathrooms
        </label>

        <label>
          <input type="checkbox" name="tags[]" value="Sensory-Friendly" <?php echo in_array('Sensory-Friendly', $selectedTags) ? 'checked' : ''; ?>>
          Sensory-Friendly
        </label>

        <label>
          <input type="checkbox" name="tags[]" value="Eco-Friendly" <?php echo in_array('Eco-Friendly', $selectedTags) ? 'checked' : ''; ?>>
          Eco-Friendly
        </label>

        <br><br>
        <button type="submit" id="filter-button">Filter</button>
      </form>
    </div>
    <!-- </div> -->

    <div class="results">
      <?php if (!empty($locations)): ?>
        <p id="result-count"><?php echo count($locations); ?> Results Found:</p>
        <?php foreach ($locations as $location): ?>
          <div class="result">
            <div class="left-content">
              <?php
              $locationId = $location['id'];
              $imagePath = isset($imageMap[$locationId]) ? $imageMap[$locationId] : 'images/default.jpg';
              ?>
              <img id="result-image" src="<?php echo htmlspecialchars($imagePath); ?>" alt="Location Image">

              <div class="rating">
                <p>♡ <?php echo htmlspecialchars($location['favourites']); ?></p>
                <p>👎 <?php echo htmlspecialchars($location['dislikes']); ?></p>
              </div>
            </div>
            <div class="right-content">
              <div class="name-money">
                <p id="name"><?php echo htmlspecialchars($location['name']); ?></p>
                <p id="money"><?php echo htmlspecialchars($location['price']); ?></p>
              </div>
              <p id="address"><?php echo htmlspecialchars($location['address']); ?></p>
              <p id="description"><?php echo htmlspecialchars($location['description']); ?></p>
              <div class="tags">
                <?php
                $tags = preg_split('/[\|,]/', $location['tags']);
                foreach ($tags as $tag): ?>
                  <p class="tag"><?php echo htmlspecialchars(trim($tag)); ?></p>
                <?php endforeach; ?>
              </div>
              <div class="review">
                <p>"Read Reviews"</p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p id="result-count">No Results Found</p>
      <?php endif; ?>
    </div>
  </div>

  <script>
    document.querySelectorAll("label input[type='checkbox']").forEach(checkbox => {
      checkbox.addEventListener("change", function () {
        if (this.checked) {
          this.parentNode.classList.add("active");
        } else {
          this.parentNode.classList.remove("active");
        }
      });
      // Initialize active state on page load if checkbox is already checked
      if (checkbox.checked) {
        checkbox.parentNode.classList.add("active");
      }
    });
  </script>
</body>

</html>