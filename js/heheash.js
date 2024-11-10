// Function to handle the dropdown change
function handleDropdownChange() {
    const dropdown = document.querySelector(".dropdown-select");
    const selectedValue = dropdown.value;
  
    if (selectedValue) {
      // Redirect to locations.php with selected value as search query
      window.location.href = `locations.php?search=${selectedValue}`;
    }
  }
  
  // Function to sequentially fade in images
  function sequentialFadeIn() {
    const images = document.querySelectorAll(".fade-in-image");
  
    images.forEach((image, index) => {
      setTimeout(() => {
        image.classList.add("visible");
      }, index * 75); // Delay each image by 500ms
    });
  }
  
  // Attach event listeners on DOMContentLoaded
  document.addEventListener("DOMContentLoaded", function () {
    // Attach the dropdown change handler
    const dropdown = document.querySelector(".dropdown-select");
    dropdown.addEventListener("change", handleDropdownChange);
  
    // Call the sequential fade-in function for images
    sequentialFadeIn();
  });
  