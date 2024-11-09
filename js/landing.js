document.addEventListener("DOMContentLoaded", function () {
  const dropdownButton = document.querySelector(".dropdown-button");
  const dropdownOptions = document.querySelector(".dropdown-options");
  const contentBox = document.querySelector(".content-box");

  dropdownButton.addEventListener("click", function () {
    const isVisible = dropdownOptions.style.display === "block";

    if (isVisible) {
      dropdownOptions.style.display = "none";
      contentBox.style.paddingBottom = "20px"; // Reset the padding of the content-box
    } else {
      dropdownOptions.style.display = "block";
      contentBox.style.paddingBottom = `${dropdownOptions.scrollHeight + 20}px`;
    }
  });

  // Optionally handle clicks on dropdown items
  document.querySelectorAll(".dropdown-option").forEach((option) => {
    option.addEventListener("click", function () {
      dropdownButton.innerText = this.innerText;
      dropdownOptions.style.display = "none";
      contentBox.style.paddingBottom = "20px";
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
    }
  });
});
