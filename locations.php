<?php
$csvFile = "locations.csv"; // Path to your CSV file

$locations = [];
$selected_tags = [];

// Function to read data from CSV file
function readCSV($csvFile)
{
  $file = fopen($csvFile, 'r');
  $data = [];

  if ($file !== FALSE) {
    $headers = fgetcsv($file); // Read the first row as header
    while (($row = fgetcsv($file)) !== FALSE) {
      $data[] = array_combine($headers, $row);
    }
    fclose($file);
  }

  return $data;
}

// Read data from the CSV file
$locations = readCSV($csvFile);

// Check if tags are selected and filter accordingly
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tags']) && is_array($_POST['tags']) && !empty($_POST['tags'])) {
  $selected_tags = $_POST['tags'];

  // Filter the locations based on selected tags
  $locations = array_filter($locations, function ($location) use ($selected_tags) {
    foreach ($selected_tags as $tag) {
      if (stripos($location['tags'], $tag) === false) {
        return false; // If one of the selected tags is not in location tags, exclude this location
      }
    }
    return true;
  });
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Find Locations by Tags</title>
  <link rel="stylesheet" href="css/results.css">
  <link href="https://fonts.googleapis.com/css?family=Baloo" rel="stylesheet">
</head>

<body>
  <nav>
    <div id="logo-container">
      <img src="images/logo.png" alt="logo" id="logo">
      <p id="site-name">HIDDEN HAVENS</p>
    </div>
    <form action="/search" method="get" id="search-form">
      <input type="search" placeholder="Search..." id="search-bar">
      <button type="submit" id="search-button">Search</button>
    </form>
    <button id="login-button">Log In</button>
  </nav>

  <div class="content-box">
    <div class="filter-area">
      <p id="filter-results">Filter Results</p>
      <form method="post" action="" id="filter-form">
        <label>
          <input type="checkbox" name="tags[]" value="Women-Centered" <?php echo in_array('Women-Centered', $selected_tags) ? 'checked' : ''; ?>> Women-Centered
        </label>
        <label>
          <input type="checkbox" name="tags[]" value="LGBTQ+" <?php echo in_array('LGBTQ+', $selected_tags) ? 'checked' : ''; ?>> LGBTQ+
        </label>
        <label>
          <input type="checkbox" name="tags[]" value="Accessible" <?php echo in_array('Accessible', $selected_tags) ? 'checked' : ''; ?>> Accessible
        </label>
        <label>
          <input type="checkbox" name="tags[]" value="Body Positive" <?php echo in_array('Body Positive', $selected_tags) ? 'checked' : ''; ?>> Body Positive
        </label>
        <label>
          <input type="checkbox" name="tags[]" value="All-Gender Bathrooms" <?php echo in_array('All-Gender Bathrooms', $selected_tags) ? 'checked' : ''; ?>> All-Gender Bathrooms
        </label>
        <label>
          <input type="checkbox" name="tags[]" value="Sensory-Friendly" <?php echo in_array('Sensory-Friendly', $selected_tags) ? 'checked' : ''; ?>> Sensory-Friendly
        </label>
        <label>
          <input type="checkbox" name="tags[]" value="Eco-Friendly" <?php echo in_array('Eco-Friendly', $selected_tags) ? 'checked' : ''; ?>> Eco-Friendly
        </label>
        <br><br>
        <button type="submit" id="filter-button">Filter</button>
      </form>
    </div>

    <div class="results">
      <?php if (!empty($locations)): ?>
        <p id="result-count"><?php echo count($locations); ?> Results found</p>
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
              <p id="address"><?php echo htmlspecialchars($location['address']); ?>,
                <?php echo htmlspecialchars($location['city']); ?></p>
              <p id="description"><?php echo htmlspecialchars($location['description']); ?></p>
              <div class="tags">
                <?php
                $tags = explode(',', $location['tags']);
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