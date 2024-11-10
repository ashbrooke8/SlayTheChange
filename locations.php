<?php
// Define the path for the CSV file
$csvFile = 'locations.csv';
$locations = [];

// Check if the search form is submitted
$searchTerm = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';
$selectedTags = isset($_GET['tags']) && is_array($_GET['tags']) ? $_GET['tags'] : [];

// Open the CSV file and parse its contents
if (($handle = fopen($csvFile, "r")) !== false) {
  $header = fgetcsv($handle); // Read the header line
  while (($row = fgetcsv($handle)) !== false) {
    // Convert CSV row to an associative array
    $location = array_combine($header, $row);

    // Check if the location matches the search term in the name or type, if specified
    $locationType = strtolower($location['type']);
    $locationName = strtolower($location['name']);
    $matchesSearchTerm = empty($searchTerm) ||
      stripos($locationName, $searchTerm) !== false ||
      stripos($locationType, $searchTerm) !== false;

    // Check if the location matches the selected tags
    $matchesTags = empty($selectedTags) || array_reduce($selectedTags, function ($carry, $tag) use ($location) {
      return $carry && stripos($location['tags'], $tag) !== false;
    }, true);

    // Add location if it matches both the search term and tags
    if ($matchesSearchTerm && $matchesTags) {
      $locations[] = $location;
    }
  }
  fclose($handle);
}
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
      <img src="images/logo.png" alt="logo" id="logo">
      <p id="site-name">HIDDEN HAVENS</p>
    </div>
    <form method="get" action="locations.php" id="search-form">
      <input type="search" name="search" placeholder="Search (e.g. Cafe, Starbucks)..." id="search-bar"
        value="<?php echo htmlspecialchars($searchTerm); ?>">
      <button type="submit" id="search-button">Search</button>
    </form>
    <button id="login-button">Log In</button>
  </nav>

  <div class="content-box">
    <div class="filter-area">
      <p id="filter-results">Filter Results</p>
      <form method="get" action="" id="filter-form">
        <input type="hidden" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <label>
          <input type="checkbox" name="tags[]" value="Women-Centered" <?php echo in_array('Women-Centered', $selectedTags) ? 'checked' : ''; ?>> Women-Centered
        </label>
        <label>
          <input type="checkbox" name="tags[]" value="LGBTQ+" <?php echo in_array('LGBTQ+', $selectedTags) ? 'checked' : ''; ?>> LGBTQ+
        </label>
        <label>
          <input type="checkbox" name="tags[]" value="Accessible" <?php echo in_array('Accessible', $selectedTags) ? 'checked' : ''; ?>> Accessible
        </label>
        <label>
          <input type="checkbox" name="tags[]" value="Body Positive" <?php echo in_array('Body Positive', $selectedTags) ? 'checked' : ''; ?>> Body Positive
        </label>
        <label>
          <input type="checkbox" name="tags[]" value="All-Gender Bathrooms" <?php echo in_array('All-Gender Bathrooms', $selectedTags) ? 'checked' : ''; ?>> All-Gender Bathrooms
        </label>
        <label>
          <input type="checkbox" name="tags[]" value="Sensory-Friendly" <?php echo in_array('Sensory-Friendly', $selectedTags) ? 'checked' : ''; ?>> Sensory-Friendly
        </label>
        <label>
          <input type="checkbox" name="tags[]" value="Eco-Friendly" <?php echo in_array('Eco-Friendly', $selectedTags) ? 'checked' : ''; ?>> Eco-Friendly
        </label>
        <br><br>
        <button type="submit" id="filter-button">Filter</button>
      </form>
    </div>

    <div class="results">
      <?php if (!empty($locations)): ?>
        <p id="result-count"><?php echo count(value: $locations); ?> Results found</p>
        <?php foreach ($locations as $location): ?>
          <div class="result">
            <div class="left-content">
              <img src="images/default.jpg" alt="Location Image" id="result-image"> <!-- Placeholder image -->
              <div class="rating">
                <p>♡ <?php echo htmlspecialchars($location['favorites']); ?></p>
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
                $tags = explode('|', $location['tags']);
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
</body>

</html>