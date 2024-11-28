function checkPolygonName() {
    var selectPolygon = document.getElementById("boarder-name");
    var removePolygonButton = document.getElementById("removePolygonButton");

    if (selectPolygon.value === "Add prefer") {
        // Prompt the user for the new polygon name
        var newPolygonName = prompt("Please enter the name of the new polygon:");

        if (newPolygonName) {
            // Check if the option already exists
            var existingOption = Array.from(selectPolygon.options).find(option => option.value === newPolygonName);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newPolygonName;
                newOption.value = newPolygonName;
                selectPolygon.appendChild(newOption);
            }

            // Automatically select the new option
            selectPolygon.value = newPolygonName;
            removePolygonButton.style.display = "block"; // Show remove button
        }
    } else {
        // Hide the remove button if a predefined option is selected
        removePolygonButton.style.display = selectPolygon.value ? "block" : "none";
    }
}

function removeCustomPolygon() {
    var selectPolygon = document.getElementById("boarder-name");
    var removePolygonButton = document.getElementById("removePolygonButton");

    // Remove the last selected custom option
    if (selectPolygon.value && selectPolygon.value !== "Add prefer") {
        var selectedValue = selectPolygon.value;
        var optionToRemove = Array.from(selectPolygon.options).find(option => option.value === selectedValue);

        if (optionToRemove) {
            selectPolygon.remove(optionToRemove.index);
        }

        // Reset the select dropdown and hide the remove button
        selectPolygon.value = ""; // Reset the select dropdown
        removePolygonButton.style.display = "none"; // Hide remove button
    }
}