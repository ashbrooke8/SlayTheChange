document.addEventListener("DOMContentLoaded", function () {
  const dropdownButton = document.querySelector(".dropdown-button");
  const dropdownOptions = document.querySelector(".dropdown-options");
  const contentBox = document.querySelector(".content-box");

  dropdownButton.addEventListener("click", function (event) {
    event.stopPropagation(); // Prevent the click from closing immediately

    // Toggle dropdown visibility
    const isVisible = dropdownOptions.style.display === "block";
    dropdownOptions.style.display = isVisible ? "none" : "block";

    // Adjust padding of the content-box to accommodate dropdown
    if (!isVisible) {
      contentBox.style.paddingBottom = `${dropdownOptions.scrollHeight + 20}px`;
      document.body.classList.add("no-scroll"); // Disable scrolling
    } else {
      contentBox.style.paddingBottom = "20px";
      document.body.classList.remove("no-scroll"); // Enable scrolling
    }
  });

  // Handle option selection
  document.querySelectorAll(".dropdown-option").forEach((option) => {
    option.addEventListener("click", function () {
      dropdownButton.innerText = this.innerText; // Set selected option as button text
      dropdownButton.style.color = "#333"; // Change text color to black once an option is selected
      dropdownOptions.style.display = "none";
      contentBox.style.paddingBottom = "20px";
      document.body.classList.remove("no-scroll"); // Enable scrolling
    });
  });

  // Close the dropdown when clicking outside
  document.addEventListener("click", function (e) {
    if (
      !dropdownButton.contains(e.target) &&
      !dropdownOptions.contains(e.target)
    ) {
      dropdownOptions.style.display = "none";
      contentBox.style.paddingBottom = "20px";
      document.body.classList.remove("no-scroll"); // Enable scrolling
    }
  });
});
