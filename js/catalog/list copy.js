document.addEventListener("DOMContentLoaded", function () {
  const minPriceInput = document.getElementById("minPrice");
  const maxPriceInput = document.getElementById("maxPrice");
  const applyFilterBtn = document.getElementById("applyFilter");
  const clearFilterBtn = document.getElementById("clearFilter");
  const productCards = document.querySelectorAll(".product-card");

  // console.log(minPriceInput);
  // console.log(maxPriceInput);

  function filterProducts() {
    const minPrice = parseFloat(minPriceInput.value) || 0;
    const maxPrice = parseFloat(maxPriceInput.value) || Infinity;

    // console.log(maxPrice);
    // console.log(minPrice);
    // window.location.href = currentUrl + "&min=" + minPrice + "&max=" + maxPrice;

    productCards.forEach((card) => {
      const productPrice = parseFloat(card.getAttribute("data-price"));
      console.log(card.getAttribute("data-price"));
      console.log(productPrice);

      if (productPrice >= minPrice && productPrice <= maxPrice) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  }

  applyFilterBtn.addEventListener("click", filterProducts);

  function updateURL() {
    let urlParams = new URLSearchParams(window.location.search);

    let selectedManufacturers = Array.from(
      document.querySelectorAll('input[name="manufactureres[]"]:checked')
    )
      .map((checkbox) => checkbox.value)
      .join(",");

    // Remove existing manufacturer parameter
    urlParams.delete("manufacturer");
    if (selectedManufacturers)
      urlParams.set("manufacturer", selectedManufacturers);

    // Handle Color Filter
    let selectedColors = Array.from(
      document.querySelectorAll('input[name="colors[]"]:checked')
    )
      .map((checkbox) => checkbox.value)
      .join(",");

    urlParams.delete("color"); // Remove existing
    if (selectedColors) urlParams.set("color", selectedColors);

    // Update URL without reloading the page
    window.history.pushState({}, "", "?" + urlParams.toString());
    location.reload();
  }

  function setCheckboxesFromURL() {
    let urlParams = new URLSearchParams(window.location.search);

    // Set Manufacturer Checkboxes
    let selectedManufacturers = urlParams.get("manufacturer")
      ? urlParams.get("manufacturer").split(",")
      : [];
    document
      .querySelectorAll('input[name="manufactureres[]"]')
      .forEach((checkbox) => {
        checkbox.checked = selectedManufacturers.includes(checkbox.value);
      });

    // Set Color Checkboxes
    let selectedColors = urlParams.get("color")
      ? urlParams.get("color").split(",")
      : [];
    document.querySelectorAll('input[name="colors[]"]').forEach((checkbox) => {
      checkbox.checked = selectedColors.includes(checkbox.value);
    });
  }

  // Set checkboxes on page load
  setCheckboxesFromURL();

  // Attach event listener to checkboxes
  document
    .querySelectorAll('input[name="manufactureres[]"], input[name="colors[]"]')
    .forEach((checkbox) => {
      checkbox.addEventListener("change", updateURL);
    });

  function clearfilterProducts() {
    let urlParams = new URLSearchParams(window.location.search);
    urlParams.delete("manufacturer");
    urlParams.delete("color");
    window.history.pushState({}, "", "?" + urlParams.toString());
    location.reload();
  }
  clearFilterBtn.addEventListener("click", clearfilterProducts);
});

// document.addEventListener('DOMContentLoaded', function() {
//     setCheckboxesFromURL();
//     document.querySelectorAll('.filter-checkbox').forEach((checkbox) => {
//         checkbox.addEventListener('change', function() {
//             updateURL();
//         });
//     });
// });

// -----------------------------------------------------------
// function updateURL() {
//     let checkboxes = document.querySelectorAll('.filter-checkbox');
//     let urlParams = new URLSearchParams(window.location.search);
//     let selectedCategories = urlParams.getAll('name');
//     let newCategories = [];

//     // Process each checkbox
//     checkboxes.forEach((checkbox) => {
//         const categoryValue = checkbox.value;

//         // If checkbox is checked and not already in URL, add it
//         if (checkbox.checked && !selectedCategories.includes(categoryValue)) {
//             newCategories.push(categoryValue);
//         }
//         // If checkbox is checked and already in URL, keep it (unless it was just unchecked)
//         else if (checkbox.checked && selectedCategories.includes(categoryValue)) {
//             newCategories.push(categoryValue);
//         }
//         // If unchecked and in URL, it was just unchecked - don't add to new list
//     });

//     let query = newCategories.map(category => `cid=${category}`).join('&');

//     // Update URL and reload
//     window.history.pushState({}, '', query ? `?${query}` : window.location.pathname);
//     window.location.reload();
// }

// function setCheckboxesFromURL() {
//     let urlParams = new URLSearchParams(window.location.search);
//     let categories = urlParams.getAll('cid');

//     let checkboxes = document.querySelectorAll('.filter-checkbox');
//     checkboxes.forEach((checkbox) => {
//         checkbox.checked = categories.includes(checkbox.value);
//     });
// }
// document.addEventListener('DOMContentLoaded', setCheckboxesFromURL);
