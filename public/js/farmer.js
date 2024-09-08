// selecting add to no. of children
// Function to handle No. of Children selection
function checkChildren() {
    var selectChildren = document.getElementById("childrenSelect");
    var ChildrenInputField = document.getElementById("ChildrenInputField");
    var removeChildrenButton = document.getElementById("removeChildrenButton");

    if (selectChildren.value === "Add") {
        var newChildrenNumber = prompt("Please enter the number of children:");

        if (newChildrenNumber) {
            // Check if the option already exists
            var existingOption = Array.from(selectChildren.options).find(option => option.value === newChildrenNumber);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newChildrenNumber;
                newOption.value = newChildrenNumber;
                selectChildren.appendChild(newOption);
            }

            // Automatically select the new option
            selectChildren.value = newChildrenNumber;

            // Hide the input field
            ChildrenInputField.style.display = "none";
            removeChildrenButton.style.display = "block"; // Show remove button
        } else {
            // Show the input field if no value was entered in the prompt
            ChildrenInputField.style.display = "block";
            removeChildrenButton.style.display = "none"; // Hide remove button
        }
    } else {
        // Hide the input field when not selecting 'Add'
        ChildrenInputField.style.display = "none";
        removeChildrenButton.style.display = "none"; // Hide remove button
    }
}

// Function to remove the selected No. of Children (if it's not a default option)
function removeChildren() {
    var selectChildren = document.getElementById("childrenSelect");
    var selectedValue = selectChildren.value;

    if (selectedValue && selectedValue !== "Add" && ![
            "1", "2", "3", "4", "5", "N/A"
        ].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectChildren.selectedIndex;
            selectChildren.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById("removeChildrenButton").style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}


// selecting a highest formal edu
// Function to handle Highest Formal Education selection
function checkFormalEduc() {
    var selectEduc = document.getElementById("selectEduc");
    var EducationInputField = document.getElementById("EducationInputField");
    var removeEducationButton = document.getElementById("removeEducationButton");

    if (selectEduc.value === "Add") {
        var newEduc = prompt("Please enter the highest formal education:");

        if (newEduc) {
            // Check if the option already exists
            var existingOption = Array.from(selectEduc.options).find(option => option.value === newEduc);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newEduc;
                newOption.value = newEduc;
                selectEduc.appendChild(newOption);
            }

            // Automatically select the new option
            selectEduc.value = newEduc;

            // Hide the input field
            EducationInputField.style.display = "none";
            removeEducationButton.style.display = "block"; // Show remove button
        } else {
            // Show the input field if no value was entered in the prompt
            EducationInputField.style.display = "block";
            removeEducationButton.style.display = "none"; // Hide remove button
        }
    } else {
        // Hide the input field when not selecting 'Add'
        EducationInputField.style.display = "none";
        removeEducationButton.style.display = "none"; // Hide remove button
    }
}

// Function to remove the selected Highest Formal Education (if it's not a default option)
function removeFormalEduc() {
    var selectEduc = document.getElementById("selectEduc");
    var selectedValue = selectEduc.value;

    if (selectedValue && selectedValue !== "Add" && ![
            "No Formal Education", "Primary Education", "Secondary Education", "Vocational Training", "Bachelors Degree", "Masters Degree", "Doctorate", "Other"
        ].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectEduc.selectedIndex;
            selectEduc.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById("removeEducationButton").style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}




// selected a place of birth
// Function to handle Place of Birth selection
function checkPlaceBirth() {
    var selectPlaceBirth = document.getElementById("selectPlaceBirth");
    var PlaceBirthInputField = document.getElementById("PlaceBirthInputField");
    var removePlaceBirthButton = document.getElementById("removePlaceBirthButton");

    if (selectPlaceBirth.value === "Add Place of Birth") {
        var newPlaceBirth = prompt("Please enter the place of birth:");

        if (newPlaceBirth) {
            // Check if the option already exists
            var existingOption = Array.from(selectPlaceBirth.options).find(option => option.value === newPlaceBirth);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newPlaceBirth;
                newOption.value = newPlaceBirth;
                selectPlaceBirth.appendChild(newOption);
            }

            // Automatically select the new option
            selectPlaceBirth.value = newPlaceBirth;

            // Hide the input field
            PlaceBirthInputField.style.display = "none";
            removePlaceBirthButton.style.display = "block"; // Show remove button
        } else {
            // Show the input field if no value was entered in the prompt
            PlaceBirthInputField.style.display = "block";
            removePlaceBirthButton.style.display = "none"; // Hide remove button
        }
    } else {
        // Hide the input field when not selecting 'Add Place of Birth'
        PlaceBirthInputField.style.display = "none";
        removePlaceBirthButton.style.display = "none"; // Hide remove button
    }
}

// Function to remove the selected Place of Birth (if it's not a default option)
function removePlaceBirth() {
    var selectPlaceBirth = document.getElementById("selectPlaceBirth");
    var selectedValue = selectPlaceBirth.value;

    if (selectedValue && selectedValue !== "Add Place of Birth" && ![
            "Zamboanga City", "Basilan Province", "Vitali,ZC", "Limaong,ZC", "Cotabato",
            "South Cotabato", "Bunguiao, Zc", "Manicahan,Zc", "Negros Occidental",
            "Mercedes, ZC", "Curuan, ZC", "Boalan, Zc", "Guiwan, Zc", "Cabatangan, Zc",
            "Tugbungan, Zc", "Talabaan, Zc", "Culianan, Zc", "Ayala, Zc"
        ].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectPlaceBirth.selectedIndex;
            selectPlaceBirth.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById("removePlaceBirthButton").style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}


// check the pwde when users click yes will  open new input box to add the pwd id no.
function checkPWD() {
    var selectPWD = document.getElementById("selectPWD");
    var YesInputSelected = document.getElementById("YesInputSelected");
    var NoInputSelected = document.getElementById("NoInputSelected");

    if (selectPWD.value === "1") {
        YesInputSelected.style.display = "block";
        NoInputSelected.style.display = "none";
    } else if (selectPWD.value === "0") {
        NoInputSelected.style.display = "block";
        YesInputSelected.style.display = "none";
    } else {
        YesInputSelected.style.display = "none";
        NoInputSelected.style.display = "none";
    }
}

// function checkMmbership() {
//     var selectMember = document.getElementById("selectMember");
//     var YesFarmersGroup = document.getElementById("YesFarmersGroup");
//     var NoFarmersGroup = document.getElementById("NoFarmersGroup");

//     if (selectMember.value === "1") {
//         YesFarmersGroup.style.display = "block";
//         NoFarmersGroup.style.display = "none";
//     } else if (selectMember.value === "0") {
//         NoFarmersGroup.style.display = "block";
//         YesFarmersGroup.style.display = "none";
//     } else {
//         YesFarmersGroup.style.display = "none";
//         NoFarmersGroup.style.display = "none";
//     }
// }

// check the seleced government id
function CheckGoverniD() {
    var selectGov = document.getElementById("selectGov");
    var iDtypeSelected = document.getElementById("iDtypeSelected");
    var NoSelected = document.getElementById("NoSelected");

    if (selectGov.value === "Yes") {
        iDtypeSelected.style.display = "block";
        NoSelected.style.display = "none";
    } else if (selectGov.value === "No") {
        NoSelected.style.display = "block";
        iDtypeSelected.style.display = "none";
    } else {
        iDtypeSelected.style.display = "none";
        NoSelected.style.display = "none";
    }
}
// check selected GOV ID TYPE then input n/afunction checkIDtype() {
var selectIDType = document.getElementById("selectIDType");
var idNoInput = document.getElementById("idNoInput");
var OthersInput = document.getElementById("OthersInput");
var OtherIDInput = document.getElementById("OtherIDInput");

// Clear previous options in the dropdown
selectIDType.innerHTML = '';

// Define the list of available ID types
var idTypes = [
    "Driver License", "Passport", "Postal ID", "Phylsys ID", "PRC ID",
    "Brgy. ID", "Voters ID", "Senior ID", "PhilHealth ID", "Tin ID", "BIR ID"
];

// Add the 'Select' placeholder option
var placeholderOption = document.createElement("option");
placeholderOption.text = "Select";
placeholderOption.disabled = true;
placeholderOption.selected = true;
selectIDType.appendChild(placeholderOption);

// Populate the dropdown with predefined ID types
idTypes.forEach(function(idType) {
    var option = document.createElement("option");
    option.text = idType;
    option.value = idType;
    selectIDType.appendChild(option);
});

// Add the 'Add New ID Type' option
var addNewOption = document.createElement("option");
addNewOption.text = "Add New ID Type";
addNewOption.value = "addNew";
selectIDType.appendChild(addNewOption);

// Event listener for ID type selection
selectIDType.addEventListener("change", function() {
    if (selectIDType.value === "addNew") {
        // Show input fields to add a new ID type
        OthersInput.style.display = "block";
        OtherIDInput.style.display = "block";
        idNoInput.style.display = "none"; // Hide ID number input
    } else if (idTypes.includes(selectIDType.value)) {
        // Show the ID number input for known ID types
        idNoInput.style.display = "block";
        OthersInput.style.display = "none"; // Hide other input fields
        OtherIDInput.style.display = "none";
    } else {
        // Hide all input fields when nothing is selected
        idNoInput.style.display = "none";
        OthersInput.style.display = "none";
        OtherIDInput.style.display = "none";
    }
});

// Function to handle Gov ID Type selection
function checkIDtype() {
    var selectIDType = document.getElementById("selectIDType");
    var removeIDButton = document.getElementById("removeIDButton");

    if (selectIDType.value === "addNew") {
        var newIDType = prompt("Please enter the ID type:");

        if (newIDType) {
            // Check if the option already exists
            var existingOption = Array.from(selectIDType.options).find(option => option.value === newIDType);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newIDType;
                newOption.value = newIDType;
                selectIDType.appendChild(newOption);
            }

            // Automatically select the new option
            selectIDType.value = newIDType;

            // Show the remove button
            removeIDButton.style.display = "block";
        } else {
            // Hide the remove button if no value was entered
            removeIDButton.style.display = "none";
        }
    } else {
        // Hide the remove button if a default option is selected
        removeIDButton.style.display = "none";
    }
}

// Function to remove the selected Gov ID Type (if it's not a default option)
function removeIDType() {
    var selectIDType = document.getElementById("selectIDType");
    var selectedValue = selectIDType.value;

    if (selectedValue && selectedValue !== "addNew" && ![
            "Driver License", "Passport", "Postal ID", "Phylsys ID", "PRC ID", "Brgy. ID", "Voters ID", "Senior ID", "PhilHealth ID", "Tin ID", "BIR ID", "N/A"
        ].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectIDType.selectedIndex;
            selectIDType.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById("removeIDButton").style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}



// tenurial status selections 
// Function to handle Tenurial Status selection
function checkTenurial() {
    var selectTenurialStatus = document.getElementById("selectTenurialStatus");
    var removeTenurialButton = document.getElementById("removeTenurialButton");

    if (selectTenurialStatus.value === "Add") {
        var newTenurialStatus = prompt("Please enter the Tenurial Status:");

        if (newTenurialStatus) {
            // Check if the option already exists
            var existingOption = Array.from(selectTenurialStatus.options).find(option => option.value === newTenurialStatus);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newTenurialStatus;
                newOption.value = newTenurialStatus;
                selectTenurialStatus.appendChild(newOption);
            }

            // Automatically select the new option
            selectTenurialStatus.value = newTenurialStatus;

            // Show the remove button
            removeTenurialButton.style.display = "block";
        } else {
            // Hide the remove button if no value was entered
            removeTenurialButton.style.display = "none";
        }
    } else {
        // Hide the remove button if a default option is selected
        removeTenurialButton.style.display = "none";
    }
}

// Function to remove the selected Tenurial Status (if it's not a default option)
function removeTenurial() {
    var selectTenurialStatus = document.getElementById("selectTenurialStatus");
    var selectedValue = selectTenurialStatus.value;

    if (selectedValue && selectedValue !== "Add" && ![
            "Owner", "Owner Tiller", "Tenant", "Tiller", "Lease"
        ].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectTenurialStatus.selectedIndex;
            selectTenurialStatus.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById("removeTenurialButton").style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}


// selected prone area

// Function to handle Area Prone To selection
function checkProne() {
    var selectAreaprone = document.getElementById("selectedAreaprone");
    var removeProneButton = document.getElementById("removeProneButton");

    if (selectAreaprone.value === "Add Prone") {
        var newAreaProne = prompt("Please enter the Area Prone To:");

        if (newAreaProne) {
            // Check if the option already exists
            var existingOption = Array.from(selectAreaprone.options).find(option => option.value === newAreaProne);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newAreaProne;
                newOption.value = newAreaProne;
                selectAreaprone.appendChild(newOption);
            }

            // Automatically select the new option
            selectAreaprone.value = newAreaProne;

            // Show the remove button
            removeProneButton.style.display = "block";
        } else {
            // Hide the remove button if no value was entered
            removeProneButton.style.display = "none";
        }
    } else {
        // Hide the remove button if a default option is selected
        removeProneButton.style.display = "none";
    }
}

// Function to remove the selected Area Prone To (if it's not a default option)
function removeProne() {
    var selectAreaprone = document.getElementById("selectedAreaprone");
    var selectedValue = selectAreaprone.value;

    if (selectedValue && selectedValue !== "Add Prone" && ![
            "Flood", "Drought", "Saline", "N/A"
        ].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectAreaprone.selectedIndex;
            selectAreaprone.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById("removeProneButton").style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}


// check of ecosystem
// Function to handle Ecosystem selection
function checkEcosystem() {
    var selectEcosystem = document.getElementById("selectedEcosystem");
    var removeEcosystemButton = document.getElementById("removeEcosystemButton");

    if (selectEcosystem.value === "Add ecosystem") {
        var newEcosystem = prompt("Please enter the Ecosystem:");

        if (newEcosystem) {
            // Check if the option already exists
            var existingOption = Array.from(selectEcosystem.options).find(option => option.value === newEcosystem);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newEcosystem;
                newOption.value = newEcosystem;
                selectEcosystem.appendChild(newOption);
            }

            // Automatically select the new option
            selectEcosystem.value = newEcosystem;

            // Show the remove button
            removeEcosystemButton.style.display = "block";
        } else {
            // Hide the remove button if no value was entered
            removeEcosystemButton.style.display = "none";
        }
    } else {
        // Hide the remove button if a default option is selected
        removeEcosystemButton.style.display = "none";
    }
}

// Function to remove the selected Ecosystem (if it's not a default option)
function removeEcosystem() {
    var selectEcosystem = document.getElementById("selectedEcosystem");
    var selectedValue = selectEcosystem.value;

    if (selectedValue && selectedValue !== "Add ecosystem" && ![
            "Lowland Rain Fed", "Lowland Irrigated"
        ].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectEcosystem.selectedIndex;
            selectEcosystem.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById("removeEcosystemButton").style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}





// check selected in  civil status if  ist is single, married, widow ordivorced
function checkCivil() {
    var selectCivil = document.getElementById("selectCivil");
    var MariedInputSelected = document.getElementById("MariedInputSelected");
    var SinWidDevInput = document.getElementById("SinWidDevInput");

    if (selectCivil.value === "Maried") {
        MariedInputSelected.style.display = "block";
        SinWidDevInput.style.display = "none";
    } else if (selectCivil.value === "Single" || selectCivil.value === "Widow" || selectCivil.value === "Divorced") {
        SinWidDevInput.style.display = "block";
        MariedInputSelected.style.display = "none";
    } else {
        MariedInputSelected.style.display = "none";
        SinWidDevInput.style.display = "none";
    }
}


// Function to handle Seed Source selection
function checkSeedSource(cropCounter) {
    var selectSeedSource = document.getElementById(`seed_source_${cropCounter}`);
    var removeSeedSourceButton = document.getElementById(`removeSeedSourceButton_${cropCounter}`);

    if (selectSeedSource.value === "Add") {
        var newSeedSource = prompt("Please enter the Seed Source:");

        if (newSeedSource) {
            // Check if the option already exists
            var existingOption = Array.from(selectSeedSource.options).find(option => option.value === newSeedSource);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newSeedSource;
                newOption.value = newSeedSource;
                selectSeedSource.appendChild(newOption);
            }

            // Automatically select the new option
            selectSeedSource.value = newSeedSource;

            // Show the remove button
            removeSeedSourceButton.style.display = "block";
        } else {
            // Hide the remove button if no value was entered
            removeSeedSourceButton.style.display = "none";
        }
    } else {
        // Hide the remove button if a default option is selected
        removeSeedSourceButton.style.display = "none";
    }
}

// Function to remove the selected Seed Source (if it's not a default option)
function removeSeedSource(cropCounter) {
    var selectSeedSource = document.getElementById(`seed_source_${cropCounter}`);
    var selectedValue = selectSeedSource.value;

    if (selectedValue && selectedValue !== "Add" && ![
            "Government Subsidy", "Traders", "Own"
        ].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectSeedSource.selectedIndex;
            selectSeedSource.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById(`removeSeedSourceButton_${cropCounter}`).style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}


// Function to handle Particular selection
function checkParticular(cropCounter) {
    var selectParticular = document.getElementById(`particular_${cropCounter}`);
    var removeParticularButton = document.getElementById(`removeParticularButton_${cropCounter}`);

    if (selectParticular.value === "Other") {
        var newParticular = prompt("Please enter the Particular:");

        if (newParticular) {
            // Check if the option already exists
            var existingOption = Array.from(selectParticular.options).find(option => option.value === newParticular);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newParticular;
                newOption.value = newParticular;
                selectParticular.appendChild(newOption);
            }

            // Automatically select the new option
            selectParticular.value = newParticular;

            // Show the remove button
            removeParticularButton.style.display = "block";
        } else {
            // Hide the remove button if no value was entered
            removeParticularButton.style.display = "none";
        }
    } else {
        // Hide the remove button if a default option is selected
        removeParticularButton.style.display = "none";
    }
}

// Function to remove the selected Particular (if it's not a default option)
function removeParticular(cropCounter) {
    var selectParticular = document.getElementById(`particular_${cropCounter}`);
    var selectedValue = selectParticular.value;

    if (selectedValue && selectedValue !== "Other" && ![
            "Land Rental Cost", "Land Ownership Cost", "Equipment Costs", "Infrastructure Costs"
        ].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectParticular.selectedIndex;
            selectParticular.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById(`removeParticularButton_${cropCounter}`).style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}


// Function to add calculation listeners to the crop section



// adding new extend name when the users click  others 

// Function to handle Extension Name selection
function checkExtendN() {
    var selectExtendName = document.getElementById("selectExtendName");
    var OthersInputField = document.getElementById("OthersInputField");
    var removeExtendButton = document.getElementById("removeExtendButton");

    if (selectExtendName.value === "others") {
        var newExtendName = prompt("Please enter the name for 'Others' (optional):");

        if (newExtendName) {
            // Check if the option already exists
            var existingOption = Array.from(selectExtendName.options).find(option => option.value === newExtendName);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newExtendName;
                newOption.value = newExtendName;
                selectExtendName.appendChild(newOption);
            }

            // Automatically select the new option
            selectExtendName.value = newExtendName;

            // Hide the input field
            OthersInputField.style.display = "none";
            removeExtendButton.style.display = "block"; // Show remove button
        } else {
            // Show the input field if no value was entered in the prompt
            OthersInputField.style.display = "block";
            removeExtendButton.style.display = "none"; // Hide remove button
        }
    } else {
        // Hide the input field when not selecting 'Others'
        OthersInputField.style.display = "none";
        removeExtendButton.style.display = "none"; // Hide remove button
    }
}

// Function to remove the selected Religion (if it's not a default option)
function removeReligion() {
    var selectReligion = document.getElementById("selectReligion");
    var selectedValue = selectReligion.value;

    if (selectedValue && selectedValue !== "other" && !["Christianity", "Islam", "Hinduism", "Buddhism"].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectReligion.selectedIndex;
            selectReligion.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById("removeReligionButton").style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}

// Function to remove the selected Extension Name (if it's not a default option)
function removeExtendN() {
    var selectExtendName = document.getElementById("selectExtendName");
    var selectedValue = selectExtendName.value;

    if (selectedValue && selectedValue !== "others" && !["Sr.", "Jr.", "II", "III", "N/A"].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectExtendName.selectedIndex;
            selectExtendName.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById("removeExtendButton").style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}

// adding new religion when the users clicl  others 
function checkReligion() {
    var selectReligion = document.getElementById("selectReligion");
    var ReligionInputField = document.getElementById("ReligionInputField");
    var removeButton = document.getElementById("removeReligionButton");

    if (selectReligion.value === "other") {
        ReligionInputField.style.display = "block";
        removeButton.style.display = "none"; // Hide the remove button initially

        // Prompt for new religion name
        var newReligionName = prompt("Enter the name of the new religion:");
        if (newReligionName) {
            var religionSelect = document.getElementById("selectReligion");
            var existingOption = Array.from(religionSelect.options).find(option => option.value === newReligionName);

            if (!existingOption) {
                // Add new religion to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newReligionName;
                newOption.value = newReligionName;
                religionSelect.appendChild(newOption);

                // Set the new religion as selected
                religionSelect.value = newReligionName;

                // Show the remove button
                removeButton.style.display = "inline-block";
            } else {
                alert("Religion already exists.");
            }
        }
    } else {
        ReligionInputField.style.display = "none";
        removeButton.style.display = "none"; // Hide the remove button if not needed
    }
}

function removeReligion() {
    var selectReligion = document.getElementById("selectReligion");
    var selectedValue = selectReligion.value;

    if (selectedValue && selectedValue !== "other") {
        var confirmRemove = confirm("Are you sure you want to remove this religion?");
        if (confirmRemove) {
            // Remove the selected option
            var selectedIndex = selectReligion.selectedIndex;
            selectReligion.remove(selectedIndex);

            // Hide the remove button after removing
            document.getElementById("removeReligionButton").style.display = "none";
        }
    } else {
        alert("Please select a valid religion to remove.");
    }

}
// Function to handle "Plowing Machineries Used" selection
function checkPlowing(cropCounter) {
    var selectPlowing = document.getElementById(`selectPlowing_${cropCounter}`);
    var removePlowingButton = document.getElementById(`removePlowingButton_${cropCounter}`);

    if (selectPlowing.value === "OthersPlowing") {
        var newPlowing = prompt("Please enter the Plowing Machinery Used:");

        if (newPlowing) {
            // Check if the option already exists
            var existingOption = Array.from(selectPlowing.options).find(option => option.value === newPlowing);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newPlowing;
                newOption.value = newPlowing;
                selectPlowing.appendChild(newOption);
            }

            // Automatically select the new option
            selectPlowing.value = newPlowing;

            // Show the remove button
            removePlowingButton.style.display = "block";
        } else {
            // Hide the remove button if no value was entered
            removePlowingButton.style.display = "none";
        }
    } else {
        // Hide the remove button if a default option is selected
        removePlowingButton.style.display = "none";
    }
}

// Function to remove the selected Plowing option (if it's not a default option)
function removePlowing(cropCounter) {
    var selectPlowing = document.getElementById(`selectPlowing_${cropCounter}`);
    var selectedValue = selectPlowing.value;

    if (selectedValue && selectedValue !== "OthersPlowing" && ![
            "Hand Tractor", "Four-Wheel Tractors", "Compact Tractors", "Rice Transplanters", "Crawler Tractors"
        ].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectPlowing.selectedIndex;
            selectPlowing.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById(`removePlowingButton_${cropCounter}`).style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}

// Function to handle "Ownership Status" selection
function checkPlowingStatus(cropCounter) {
    var selectPlowingStatus = document.getElementById(`selectPlowingStatus_${cropCounter}`);
    var removePlowingStatusButton = document.getElementById(`removePlowingStatusButton_${cropCounter}`);

    if (selectPlowingStatus.value === "Other") {
        var newPlowingStatus = prompt("Please enter the Ownership Status:");

        if (newPlowingStatus) {
            // Check if the option already exists
            var existingOption = Array.from(selectPlowingStatus.options).find(option => option.value === newPlowingStatus);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newPlowingStatus;
                newOption.value = newPlowingStatus;
                selectPlowingStatus.appendChild(newOption);
            }

            // Automatically select the new option
            selectPlowingStatus.value = newPlowingStatus;

            // Show the remove button
            removePlowingStatusButton.style.display = "block";
        } else {
            // Hide the remove button if no value was entered
            removePlowingStatusButton.style.display = "none";
        }
    } else {
        // Hide the remove button if a default option is selected
        removePlowingStatusButton.style.display = "none";
    }
}

// Function to remove the selected Ownership Status (if it's not a default option)
function removePlowingStatus(cropCounter) {
    var selectPlowingStatus = document.getElementById(`selectPlowingStatus_${cropCounter}`);
    var selectedValue = selectPlowingStatus.value;

    if (selectedValue && selectedValue !== "Other" && !["Own", "Rent"].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectPlowingStatus.selectedIndex;
            selectPlowingStatus.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById(`removePlowingStatusButton_${cropCounter}`).style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}

// Function to handle "Harrowing Machineries Used" selection
function checkHarrowing(cropCounter) {
    var selectHarrowing = document.getElementById(`selectHarrowing_${cropCounter}`);
    var removeHarrowingButton = document.getElementById(`removeHarrowingButton_${cropCounter}`);

    if (selectHarrowing.value === "OthersHarrowing") {
        var newHarrowing = prompt("Please enter the Harrowing Machinery Used:");

        if (newHarrowing) {
            // Check if the option already exists
            var existingOption = Array.from(selectHarrowing.options).find(option => option.value === newHarrowing);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newHarrowing;
                newOption.value = newHarrowing;
                selectHarrowing.appendChild(newOption);
            }

            // Automatically select the new option
            selectHarrowing.value = newHarrowing;

            // Show the remove button
            removeHarrowingButton.style.display = "block";
        } else {
            // Hide the remove button if no value was entered
            removeHarrowingButton.style.display = "none";
        }
    } else {
        // Hide the remove button if a default option is selected
        removeHarrowingButton.style.display = "none";
    }
}

// Function to remove the selected Harrowing Machinery Used (if it's not a default option)
function removeHarrowing(cropCounter) {
    var selectHarrowing = document.getElementById(`selectHarrowing_${cropCounter}`);
    var selectedValue = selectHarrowing.value;

    if (selectedValue && selectedValue !== "OthersHarrowing" && !["Hand Tractor", "Four-Wheel Tractors", "Compact Tractors", "Rice Transplanters", "Crawler Tractors"].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectHarrowing.selectedIndex;
            selectHarrowing.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById(`removeHarrowingButton_${cropCounter}`).style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}

// Function to handle "Ownership Status" selection
function checkOwnershipStatus(cropCounter) {
    var selectOwnershipStatus = document.getElementById(`selectOwnershipStatus_${cropCounter}`);
    var removeOwnershipStatusButton = document.getElementById(`removeOwnershipStatusButton_${cropCounter}`);

    if (selectOwnershipStatus.value === "Other") {
        var newOwnershipStatus = prompt("Please enter the Ownership Status:");

        if (newOwnershipStatus) {
            // Check if the option already exists
            var existingOption = Array.from(selectOwnershipStatus.options).find(option => option.value === newOwnershipStatus);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newOwnershipStatus;
                newOption.value = newOwnershipStatus;
                selectOwnershipStatus.appendChild(newOption);
            }

            // Automatically select the new option
            selectOwnershipStatus.value = newOwnershipStatus;

            // Show the remove button
            removeOwnershipStatusButton.style.display = "block";
        } else {
            // Hide the remove button if no value was entered
            removeOwnershipStatusButton.style.display = "none";
        }
    } else {
        // Hide the remove button if a default option is selected
        removeOwnershipStatusButton.style.display = "none";
    }
}

// Function to remove the selected Ownership Status (if it's not a default option)
function removeOwnershipStatus(cropCounter) {
    var selectOwnershipStatus = document.getElementById(`selectOwnershipStatus_${cropCounter}`);
    var selectedValue = selectOwnershipStatus.value;

    if (selectedValue && selectedValue !== "Other" && !["Own", "Rent"].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectOwnershipStatus.selectedIndex;
            selectOwnershipStatus.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById(`removeOwnershipStatusButton_${cropCounter}`).style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}

// Function to handle "Harvesting Machineries Used" selection
function checkHarvestingMachine(cropCounter) {
    var selectHarvestingMachine = document.getElementById(`selectHarvestingMachine_${cropCounter}`);
    var removeHarvestingMachineButton = document.getElementById(`removeHarvestingMachineButton_${cropCounter}`);

    if (selectHarvestingMachine.value === "Others") {
        var newHarvestingMachine = prompt("Please enter the Harvesting Machinery:");

        if (newHarvestingMachine) {
            // Check if the option already exists
            var existingOption = Array.from(selectHarvestingMachine.options).find(option => option.value === newHarvestingMachine);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newHarvestingMachine;
                newOption.value = newHarvestingMachine;
                selectHarvestingMachine.appendChild(newOption);
            }

            // Automatically select the new option
            selectHarvestingMachine.value = newHarvestingMachine;

            // Show the remove button
            removeHarvestingMachineButton.style.display = "block";
        } else {
            // Hide the remove button if no value was entered
            removeHarvestingMachineButton.style.display = "none";
        }
    } else {
        // Hide the remove button if a default option is selected
        removeHarvestingMachineButton.style.display = "none";
    }
}

// Function to remove the selected Harvesting Machinery (if it's not a default option)
function removeHarvestingMachine(cropCounter) {
    var selectHarvestingMachine = document.getElementById(`selectHarvestingMachine_${cropCounter}`);
    var selectedValue = selectHarvestingMachine.value;

    if (selectedValue && selectedValue !== "Others" && !["Hand Tractor", "Four-Wheel Tractors", "Compact Tractors", "Rice Transplanters", "Crawler Tractors"].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectHarvestingMachine.selectedIndex;
            selectHarvestingMachine.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById(`removeHarvestingMachineButton_${cropCounter}`).style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}

// Function to handle "Ownership Status" selection
function checkHarvestOwnership(cropCounter) {
    var selectHarvestOwnership = document.getElementById(`selectHarvestOwnership_${cropCounter}`);
    var removeHarvestOwnershipButton = document.getElementById(`removeHarvestOwnershipButton_${cropCounter}`);

    if (selectHarvestOwnership.value === "Other") {
        var newHarvestOwnership = prompt("Please enter the Ownership Status:");

        if (newHarvestOwnership) {
            // Check if the option already exists
            var existingOption = Array.from(selectHarvestOwnership.options).find(option => option.value === newHarvestOwnership);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newHarvestOwnership;
                newOption.value = newHarvestOwnership;
                selectHarvestOwnership.appendChild(newOption);
            }

            // Automatically select the new option
            selectHarvestOwnership.value = newHarvestOwnership;

            // Show the remove button
            removeHarvestOwnershipButton.style.display = "block";
        } else {
            // Hide the remove button if no value was entered
            removeHarvestOwnershipButton.style.display = "none";
        }
    } else {
        // Hide the remove button if a default option is selected
        removeHarvestOwnershipButton.style.display = "none";
    }
}

// Function to remove the selected Ownership Status (if it's not a default option)
function removeHarvestOwnership(cropCounter) {
    var selectHarvestOwnership = document.getElementById(`selectHarvestOwnership_${cropCounter}`);
    var selectedValue = selectHarvestOwnership.value;

    if (selectedValue && selectedValue !== "Other" && !["Own", "Rent"].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectHarvestOwnership.selectedIndex;
            selectHarvestOwnership.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById(`removeHarvestOwnershipButton_${cropCounter}`).style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}


// Function to handle "Post-harvest Machineries Used" selection
function checkPostHarvestMachine(cropCounter) {
    var selectPostHarvestMachine = document.getElementById(`selectPostHarvestMachine_${cropCounter}`);
    var removePostHarvestMachineButton = document.getElementById(`removePostHarvestMachineButton_${cropCounter}`);

    if (selectPostHarvestMachine.value === "OthersPostHarvest") {
        var newPostHarvestMachine = prompt("Please enter the Post-harvest Machinery:");

        if (newPostHarvestMachine) {
            // Check if the option already exists
            var existingOption = Array.from(selectPostHarvestMachine.options).find(option => option.value === newPostHarvestMachine);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newPostHarvestMachine;
                newOption.value = newPostHarvestMachine;
                selectPostHarvestMachine.appendChild(newOption);
            }

            // Automatically select the new option
            selectPostHarvestMachine.value = newPostHarvestMachine;

            // Show the remove button
            removePostHarvestMachineButton.style.display = "block";
        } else {
            // Hide the remove button if no value was entered
            removePostHarvestMachineButton.style.display = "none";
        }
    } else {
        // Hide the remove button if a default option is selected
        removePostHarvestMachineButton.style.display = "none";
    }
}

// Function to remove the selected Post-harvest Machinery (if it's not a default option)
function removePostHarvestMachine(cropCounter) {
    var selectPostHarvestMachine = document.getElementById(`selectPostHarvestMachine_${cropCounter}`);
    var selectedValue = selectPostHarvestMachine.value;

    if (selectedValue && selectedValue !== "OthersPostHarvest" && !["Hand Tractor", "Four-Wheel Tractors", "Compact Tractors", "Rice Transplanters", "Crawler Tractors"].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectPostHarvestMachine.selectedIndex;
            selectPostHarvestMachine.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById(`removePostHarvestMachineButton_${cropCounter}`).style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}

// Function to handle "Ownership Status" selection for Post Harvest
function checkPostHarvestOwnership(cropCounter) {
    var selectPostHarvestOwnership = document.getElementById(`selectPostHarvestOwnership_${cropCounter}`);
    var removePostHarvestOwnershipButton = document.getElementById(`removePostHarvestOwnershipButton_${cropCounter}`);

    if (selectPostHarvestOwnership.value === "Other") {
        var newOwnershipStatus = prompt("Please enter the ownership status:");

        if (newOwnershipStatus) {
            var existingOption = Array.from(selectPostHarvestOwnership.options).find(option => option.value === newOwnershipStatus);

            if (!existingOption) {
                var newOption = document.createElement("option");
                newOption.text = newOwnershipStatus;
                newOption.value = newOwnershipStatus;
                selectPostHarvestOwnership.appendChild(newOption);
            }

            selectPostHarvestOwnership.value = newOwnershipStatus;
            removePostHarvestOwnershipButton.style.display = "block";
        } else {
            removePostHarvestOwnershipButton.style.display = "none";
        }
    } else {
        removePostHarvestOwnershipButton.style.display = "none";
    }
}

// Function to remove custom "Ownership Status"
function removePostHarvestOwnership(cropCounter) {
    var selectPostHarvestOwnership = document.getElementById(`selectPostHarvestOwnership_${cropCounter}`);
    var selectedValue = selectPostHarvestOwnership.value;

    if (selectedValue && selectedValue !== "Other" && !["Own", "Rent"].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            var selectedIndex = selectPostHarvestOwnership.selectedIndex;
            selectPostHarvestOwnership.remove(selectedIndex);
            document.getElementById(`removePostHarvestOwnershipButton_${cropCounter}`).style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}

// Handle adding new seed through the modal
$(document).on('click', '[id^=save_new_seed_]', function() {
    const cropCounter = $(this).attr('id').replace('save_new_seed_', '');
    const newSeedName = $(`#new_seed_name_${cropCounter}`).val().trim();
    if (newSeedName === '') {
        alert('Please enter a seed name.');
        return;
    }

    // Add the new seed to the dropdown
    const $seedSelect = $(`#selectSeedName_${cropCounter}`);
    $seedSelect.append(new Option(newSeedName, newSeedName));

    // Optionally, you can also send the new seed to the server to save it persistently

    // Close the modal
    $(`#addSeedModal_${cropCounter}`).modal('hide');
});

// Handle the selection of the "Add New Seed" option
function handleSeedSelection(cropCounter) {
    const selectedValue = $(`#selectSeedName_${cropCounter}`).val();
    if (selectedValue === 'Add New') {
        $(`#addSeedModal_${cropCounter}`).modal('show');
    } else {
        // Show remove button if a valid seed is selected
        if (selectedValue !== '') {
            $(`#removeSeedButton_${cropCounter}`).show();
        } else {
            $(`#removeSeedButton_${cropCounter}`).hide();
        }
    }
}

// Remove selected seed option
function removeSeed(cropCounter) {
    const $seedSelect = $(`#selectSeedName_${cropCounter}`);
    const selectedValue = $seedSelect.val();
    if (selectedValue && selectedValue !== 'Add New') {
        $seedSelect.find(`option[value="${selectedValue}"]`).remove();
        // Hide the remove button after removal
        $(`#removeSeedButton_${cropCounter}`).hide();
    }
}

// Bind change event to dropdowns
$(document).on('change', '.seed_name', function() {
    const cropCounter = $(this).attr('id').replace('selectSeedName_', '');
    handleSeedSelection(cropCounter);
});



// Function to handle "Name Of Fertilizer" selection
function checkNameOfFertilizer(cropCounter) {
    var selectNameOfFertilizer = document.getElementById(`selectNameOfFertilizer_${cropCounter}`);
    var removeNameOfFertilizerButton = document.getElementById(`removeNameOfFertilizerButton_${cropCounter}`);

    if (selectNameOfFertilizer.value === "other") {
        var newFertilizerName = prompt("Please enter the name of the fertilizer:");

        if (newFertilizerName) {
            var existingOption = Array.from(selectNameOfFertilizer.options).find(option => option.value === newFertilizerName);

            if (!existingOption) {
                var newOption = document.createElement("option");
                newOption.text = newFertilizerName;
                newOption.value = newFertilizerName;
                selectNameOfFertilizer.appendChild(newOption);
            }

            selectNameOfFertilizer.value = newFertilizerName;
            removeNameOfFertilizerButton.style.display = "block";
        } else {
            removeNameOfFertilizerButton.style.display = "none";
        }
    } else {
        removeNameOfFertilizerButton.style.display = "none";
    }
}

// Function to remove custom "Name Of Fertilizer"
function removeNameOfFertilizer(cropCounter) {
    var selectNameOfFertilizer = document.getElementById(`selectNameOfFertilizer_${cropCounter}`);
    var selectedValue = selectNameOfFertilizer.value;

    if (selectedValue && selectedValue !== "other" && ![
            "Nitrogen Fertilizers",
            "Phosphorus Fertilizers",
            "Potassium Fertilizers",
            "Compound Fertilizers",
            "Organic Fertilizers",
            "Slow-Release Fertilizers",
            "Micronutrient Fertilizers",
            "Liquid Fertilizers"
        ].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            var selectedIndex = selectNameOfFertilizer.selectedIndex;
            selectNameOfFertilizer.remove(selectedIndex);
            document.getElementById(`removeNameOfFertilizerButton_${cropCounter}`).style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}


// Function to handle "Pesticides Name" selection
function checkPesticideName(cropCounter) {
    var selectPesticideName = document.getElementById(`selectPesticideName_${cropCounter}`);
    var removePesticideNameButton = document.getElementById(`removePesticideNameButton_${cropCounter}`);

    if (selectPesticideName.value === "OtherPestName") {
        var newPesticideName = prompt("Please enter the name of the pesticide:");

        if (newPesticideName) {
            var existingOption = Array.from(selectPesticideName.options).find(option => option.value === newPesticideName);

            if (!existingOption) {
                var newOption = document.createElement("option");
                newOption.text = newPesticideName;
                newOption.value = newPesticideName;
                selectPesticideName.appendChild(newOption);
            }

            selectPesticideName.value = newPesticideName;
            removePesticideNameButton.style.display = "block";
        } else {
            removePesticideNameButton.style.display = "none";
        }
    } else {
        removePesticideNameButton.style.display = "none";
    }
}

// Function to remove custom "Pesticides Name"
function removePesticideName(cropCounter) {
    var selectPesticideName = document.getElementById(`selectPesticideName_${cropCounter}`);
    var selectedValue = selectPesticideName.value;

    if (selectedValue && selectedValue !== "OtherPestName" && ![
            "Glyphosate",
            "Malathion",
            "Diazinon",
            "Chlorpyrifos",
            "Lambda-cyhalothrin",
            "Imidacloprid",
            "Cypermethrin",
            "N/A"
        ].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            var selectedIndex = selectPesticideName.selectedIndex;
            selectPesticideName.remove(selectedIndex);
            document.getElementById(`removePesticideNameButton_${cropCounter}`).style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}

// Function to handle "Seed name" selection
function checkSeedName(cropCounter) {
    var seedSelect = document.getElementById(`seed_name_${cropCounter}`);
    var removeSeedButton = document.getElementById(`seed_remove_${cropCounter}`);

    if (seedSelect.value === "add") {
        var newSeedName = prompt("Please enter the name of the seed:");

        if (newSeedName) {
            var existingOption = Array.from(seedSelect.options).find(option => option.value === newSeedName);

            if (!existingOption) {
                var newOption = document.createElement("option");
                newOption.text = newSeedName;
                newOption.value = newSeedName;
                seedSelect.appendChild(newOption);
            }

            seedSelect.value = newSeedName;
            removeSeedButton.style.display = "block";
        } else {
            removeSeedButton.style.display = "none";
        }
    } else {
        removeSeedButton.style.display = "none";
    }
}

// Function to remove custom "Seed name"
function removeSeed(cropCounter) {
    var seedSelect = document.getElementById(`seed_name_${cropCounter}`);
    var selectedValue = seedSelect.value;

    if (selectedValue && selectedValue !== "add" && ![
            "" // Add default seed options here if any
        ].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            var selectedIndex = seedSelect.selectedIndex;
            seedSelect.remove(selectedIndex);
            document.getElementById(`seed_remove_${cropCounter}`).style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}


// Function to populate Crop Variety dropdown
function populateCropVariety(cropCounter, varieties) {
    var cropVarietySelect = document.getElementById(`crop_variety_${cropCounter}`);
    cropVarietySelect.innerHTML = ''; // Clear existing options

    var defaultOption = document.createElement("option");
    defaultOption.text = "Select Variety";
    defaultOption.value = "";
    defaultOption.disabled = true;
    defaultOption.selected = true;
    cropVarietySelect.appendChild(defaultOption);

    varieties.forEach(variety => {
        var option = document.createElement("option");
        option.text = variety;
        option.value = variety;
        cropVarietySelect.appendChild(option);
    });
}

// Function to handle Crop Variety selection
function checkCropVariety(cropCounter) {
    var cropVarietySelect = document.getElementById(`crop_variety_${cropCounter}`);
    var removeVarietyButton = document.getElementById(`crop_variety_remove_${cropCounter}`);

    if (cropVarietySelect.value === "add") {
        var newVariety = prompt("Please enter the name of the crop variety:");

        if (newVariety) {
            var existingOption = Array.from(cropVarietySelect.options).find(option => option.value === newVariety);

            if (!existingOption) {
                var newOption = document.createElement("option");
                newOption.text = newVariety;
                newOption.value = newVariety;
                cropVarietySelect.appendChild(newOption);
            }

            cropVarietySelect.value = newVariety;
            removeVarietyButton.style.display = "block";
        } else {
            removeVarietyButton.style.display = "none";
        }
    } else {
        removeVarietyButton.style.display = "none";
    }
}

// Function to remove custom Crop Variety
function removeCropVariety(cropCounter) {
    var cropVarietySelect = document.getElementById(`crop_variety_${cropCounter}`);
    var selectedValue = cropVarietySelect.value;

    if (selectedValue && ![
            "" // Add default crop variety options here if any
        ].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            var selectedIndex = cropVarietySelect.selectedIndex;
            cropVarietySelect.remove(selectedIndex);
            document.getElementById(`crop_variety_remove_${cropCounter}`).style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const firstNameInput = document.getElementById('firstName');
    const middleNameInput = document.getElementById('middleName');
    const lastNameInput = document.getElementById('lastName');
    const mothersMaidenNameInput = document.getElementById('mothersMaidenName');
    // const dateOfBirthInput = document.getElementById('datepicker');
    const selectExtendName = document.getElementById('selectExtendName');
    const newExtensionNameInput = document.getElementById('newExtensionName');
    const removeExtendButton = document.getElementById('removeExtendButton');
    const nextButton = document.getElementById('nextButton');

    // Regex to match only letters and spaces
    const regex = /^[A-Za-z\s]*$/;

    // Function to validate input and disable next button if there are errors
    function validateInput() {
        let isValid = true;

        // Validate First Name
        if (firstNameInput.value.trim() === '' || !regex.test(firstNameInput.value)) {
            firstNameInput.classList.add('is-invalid');
            document.getElementById('firstNameError').textContent = firstNameInput.value.trim() === '' ?
                'First Name is required.' :
                'Invalid input. Only letters and spaces are allowed.';
            document.getElementById('firstNameError').style.display = 'block';
            isValid = false;
        } else {
            firstNameInput.classList.remove('is-invalid');
            document.getElementById('firstNameError').style.display = 'none';
        }

        // Validate Middle Name (Optional)
        if (middleNameInput.value.trim() !== '' && !regex.test(middleNameInput.value)) {
            middleNameInput.classList.add('is-invalid');
            document.getElementById('middleNameError').textContent = 'Invalid input. Only letters and spaces are allowed.';
            document.getElementById('middleNameError').style.display = 'block';
            isValid = false;
        } else {
            middleNameInput.classList.remove('is-invalid');
            document.getElementById('middleNameError').style.display = 'none';
        }

        // Validate Last Name
        if (lastNameInput.value.trim() === '' || !regex.test(lastNameInput.value)) {
            lastNameInput.classList.add('is-invalid');
            document.getElementById('lastNameError').textContent = lastNameInput.value.trim() === '' ?
                'Last Name is required.' :
                'Invalid input. Only letters and spaces are allowed.';
            document.getElementById('lastNameError').style.display = 'block';
            isValid = false;
        } else {
            lastNameInput.classList.remove('is-invalid');
            document.getElementById('lastNameError').style.display = 'none';
        }

        // Validate Mother's Maiden Name
        if (mothersMaidenNameInput.value.trim() === '' || !regex.test(mothersMaidenNameInput.value)) {
            mothersMaidenNameInput.classList.add('is-invalid');
            document.getElementById('mothers_maiden_name_error').textContent = mothersMaidenNameInput.value.trim() === '' ?
                "Mother's Maiden Name is required." :
                'Invalid input. Only letters and spaces are allowed.';
            document.getElementById('mothers_maiden_name_error').style.display = 'block';
            isValid = false;
        } else {
            mothersMaidenNameInput.classList.remove('is-invalid');
            document.getElementById('mothers_maiden_name_error').style.display = 'none';
        }

        // // Validate Date of Birth
        // if (dateOfBirthInput.value.trim() === '') {
        //     dateOfBirthInput.classList.add('is-invalid');
        //     document.getElementById('date_of_birth_error').textContent = 'Date of Birth is required.';
        //     document.getElementById('date_of_birth_error').style.display = 'block';
        //     isValid = false;
        // }
        //  else {
        //     dateOfBirthInput.classList.remove('is-invalid');
        //     document.getElementById('date_of_birth_error').style.display = 'none';
        // }

        // Validate Extension Name (if "Others" is selected)
        if (selectExtendName.value === 'others') {
            if (newExtensionNameInput.value.trim() === '' || !regex.test(newExtensionNameInput.value)) {
                newExtensionNameInput.classList.add('is-invalid');
                document.getElementById('OthersInputField').style.border = '1px solid #dc3545';
                isValid = false;
            } else {
                newExtensionNameInput.classList.remove('is-invalid');
                document.getElementById('OthersInputField').style.border = '';
            }
        }

        // Disable the Next button if the form is invalid
        updateNextButtonState(isValid);

        return isValid;
    }

    // Function to enable or disable the Next button
    function updateNextButtonState(isValid) {
        nextButton.disabled = !isValid;
    }

    // Attach event listeners for input validation
    firstNameInput.addEventListener('input', validateInput);
    middleNameInput.addEventListener('input', validateInput);
    lastNameInput.addEventListener('input', validateInput);
    mothersMaidenNameInput.addEventListener('input', validateInput);
    // dateOfBirthInput.addEventListener('input', validateInput);
    newExtensionNameInput.addEventListener('input', validateInput);

    // Attach event listeners for the Next button
    nextButton.addEventListener('click', function() {
        if (validateInput()) {
            // Optionally, show a success message or proceed to the next step
            $('#successModal').modal('show');
            document.getElementById('modalBody').textContent = 'Form is valid. Proceeding to the next step.';
        } else {
            // If "Others" is selected and the input is invalid, show a prompt
            if (selectExtendName.value === 'others' && (newExtensionNameInput.value.trim() === '' || !regex.test(newExtensionNameInput.value))) {
                let userInput = prompt('Please provide a valid extension name:');
                if (userInput !== null && regex.test(userInput)) {
                    newExtensionNameInput.value = userInput.trim();
                    newExtensionNameInput.classList.remove('is-invalid');
                } else {
                    alert('Invalid input. Only letters and spaces are allowed.');
                }
            } else {
                $('#errorModal').modal('show');
                document.getElementById('errorModalBody').textContent = 'Please fix the errors in the form.';
            }
        }
    });

    flatpickr("#datepicker", {
        dateFormat: "Y-m-d", // Date format (YYYY-MM-DD)
        // Additional options can be added here
    });


    // Attach event listener for the extension name selection
    selectExtendName.addEventListener('change', function() {
        if (selectExtendName.value === 'others') {
            document.getElementById('OthersInputField').style.display = 'block';
            removeExtendButton.style.display = 'block';
        } else {
            document.getElementById('OthersInputField').style.display = 'none';
            removeExtendButton.style.display = 'none';
            newExtensionNameInput.value = '';
            newExtensionNameInput.classList.remove('is-invalid');
        }
    });

    // Attach event listener for the remove extension name button
    removeExtendButton.addEventListener('click', function() {
        selectExtendName.value = '';
        document.getElementById('OthersInputField').style.display = 'none';
        removeExtendButton.style.display = 'none';
        newExtensionNameInput.value = '';
        newExtensionNameInput.classList.remove('is-invalid');
    });
});



// document.addEventListener('DOMContentLoaded', function() {
//     const firstNameInput = document.getElementById('firstName');
//     const middleNameInput = document.getElementById('middleName');
//     const lastNameInput = document.getElementById('lastName');
//     const mothersMaidenNameInput = document.getElementById('mothersMaidenName');
//     const dateOfBirthInput = document.getElementById('datepicker');
//     const selectExtendName = document.getElementById('selectExtendName');
//     const newExtensionNameInput = document.getElementById('newExtensionName');
//     const removeExtendButton = document.getElementById('removeExtendButton');
//     const nextButton = document.getElementById('nextButton');

//     // Regex to match only letters and spaces
//     const regex = /^[A-Za-z\s]*$/;

//     // Function to validate input and disable next button if there are errors
//     function validateInput() {
//         let isValid = true;

//         // Validate First Name
//         if (firstNameInput.value.trim() === '' || !regex.test(firstNameInput.value)) {
//             firstNameInput.classList.add('is-invalid');
//             document.getElementById('firstNameError').textContent = firstNameInput.value.trim() === '' ?
//                 'First Name is required.' :
//                 'Invalid input. Only letters and spaces are allowed.';
//             document.getElementById('firstNameError').style.display = 'block';
//             isValid = false;
//         } else {
//             firstNameInput.classList.remove('is-invalid');
//             document.getElementById('firstNameError').style.display = 'none';
//         }

//         // Validate Middle Name (Optional)
//         if (middleNameInput.value.trim() !== '' && !regex.test(middleNameInput.value)) {
//             middleNameInput.classList.add('is-invalid');
//             document.getElementById('middleNameError').textContent = 'Invalid input. Only letters and spaces are allowed.';
//             document.getElementById('middleNameError').style.display = 'block';
//             isValid = false;
//         } else {
//             middleNameInput.classList.remove('is-invalid');
//             document.getElementById('middleNameError').style.display = 'none';
//         }

//         // Validate Last Name
//         if (lastNameInput.value.trim() === '' || !regex.test(lastNameInput.value)) {
//             lastNameInput.classList.add('is-invalid');
//             document.getElementById('lastNameError').textContent = lastNameInput.value.trim() === '' ?
//                 'Last Name is required.' :
//                 'Invalid input. Only letters and spaces are allowed.';
//             document.getElementById('lastNameError').style.display = 'block';
//             isValid = false;
//         } else {
//             lastNameInput.classList.remove('is-invalid');
//             document.getElementById('lastNameError').style.display = 'none';
//         }

//         // Validate Mother's Maiden Name
//         if (mothersMaidenNameInput.value.trim() === '' || !regex.test(mothersMaidenNameInput.value)) {
//             mothersMaidenNameInput.classList.add('is-invalid');
//             document.getElementById('mothers_maiden_name_error').textContent = mothersMaidenNameInput.value.trim() === '' ?
//                 "Mother's Maiden Name is required." :
//                 'Invalid input. Only letters and spaces are allowed.';
//             document.getElementById('mothers_maiden_name_error').style.display = 'block';
//             isValid = false;
//         } else {
//             mothersMaidenNameInput.classList.remove('is-invalid');
//             document.getElementById('mothers_maiden_name_error').style.display = 'none';
//         }

//         // Validate Date of Birth
//         if (dateOfBirthInput.value.trim() === '') {
//             dateOfBirthInput.classList.add('is-invalid');
//             document.getElementById('date_of_birth_error').textContent = 'Date of Birth is required.';
//             document.getElementById('date_of_birth_error').style.display = 'block';
//             isValid = false;
//         } else {
//             dateOfBirthInput.classList.remove('is-invalid');
//             document.getElementById('date_of_birth_error').style.display = 'none';
//         }

//         // Validate Extension Name (if "Others" is selected)
//         if (selectExtendName.value === 'others') {
//             if (newExtensionNameInput.value.trim() === '' || !regex.test(newExtensionNameInput.value)) {
//                 newExtensionNameInput.classList.add('is-invalid');
//                 document.getElementById('OthersInputField').style.border = '1px solid #dc3545';
//                 isValid = false;
//             } else {
//                 newExtensionNameInput.classList.remove('is-invalid');
//                 document.getElementById('OthersInputField').style.border = '';
//             }
//         }

//         // Disable the Next button if the form is invalid
//         updateNextButtonState(isValid);

//         return isValid;
//     }

//     // Function to enable or disable the Next button
//     function updateNextButtonState(isValid) {
//         nextButton.disabled = !isValid;
//     }

//     // Attach event listeners for input validation
//     firstNameInput.addEventListener('input', validateInput);
//     middleNameInput.addEventListener('input', validateInput);
//     lastNameInput.addEventListener('input', validateInput);
//     mothersMaidenNameInput.addEventListener('input', validateInput);
//     dateOfBirthInput.addEventListener('input', validateInput);

//     // Attach event listeners for the Next button
//     nextButton.addEventListener('click', function() {
//         if (validateInput()) {
//             let firstName = firstNameInput.value;
//             let lastName = lastNameInput.value;
//             let mothersMaidenName = mothersMaidenNameInput.value;
//             let dateOfBirth = dateOfBirthInput.value;

//             if (firstName && lastName && mothersMaidenName && dateOfBirth) {
//                 // Perform AJAX call to check if the combination exists in the database
//                 fetch('/admin-view-Farmers-survey-form', {
//                         method: 'POST',
//                         headers: {
//                             'Content-Type': 'application/json',
//                             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//                         },
//                         body: JSON.stringify({
//                             first_name: firstName,
//                             last_name: lastName,
//                             mothers_maiden_name: mothersMaidenName,
//                             date_of_birth: dateOfBirth
//                         })
//                     })
//                     .then(response => response.json())
//                     .then(data => {
//                         if (data.exists) {
//                             alert('This farmer already exists in the database.');
//                         } else {
//                             // Proceed to the next step
//                             nextStep();
//                         }
//                     })
//                     .catch(error => {
//                         console.error('Error:', error);
//                         alert('An error occurred while checking the farmer. Please try again.');
//                     });
//             }
//         }
//     });

//     // Initialize datepicker
//     $('#datepicker').datepicker({
//         format: 'yyyy-mm-dd'
//     });

//     // Attach event listener for the extension name selection
//     selectExtendName.addEventListener('change', function() {
//         if (selectExtendName.value === 'others') {
//             document.getElementById('OthersInputField').style.display = 'block';
//             removeExtendButton.style.display = 'block';
//         } else {
//             document.getElementById('OthersInputField').style.display = 'none';
//             removeExtendButton.style.display = 'none';
//             newExtensionNameInput.value = '';
//         }
//     });

//     // Attach event listener for the remove extension name button
//     removeExtendButton.addEventListener('click', function() {
//         selectExtendName.value = '';
//         document.getElementById('OthersInputField').style.display = 'none';
//         removeExtendButton.style.display = 'none';
//         newExtensionNameInput.value = '';
//         newExtensionNameInput.classList.remove('is-invalid');
//     });

//     // Proceed to next step (this function should be implemented based on your form's flow)
//     function nextStep() {
//         // Handle form submission or move to the next part of the form
//         console.log('Proceeding to the next step...');
//     }
// });

// Function to handle changes in the Sex dropdown
function handleSexChange() {
    var selectSex = document.getElementById("selectSex");
    var removeSexButton = document.getElementById("removeSexButton");

    if (selectSex.value === "Others") {
        var newSex = prompt("Please enter the Sex:");

        if (newSex) {
            // Check if the option already exists
            var existingOption = Array.from(selectSex.options).find(option => option.value === newSex);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newSex;
                newOption.value = newSex;
                selectSex.appendChild(newOption);
            }

            // Automatically select the new option
            selectSex.value = newSex;

            // Show the remove button
            removeSexButton.style.display = "block";
        } else {
            // Hide the remove button if no value was entered
            removeSexButton.style.display = "none";
        }
    } else {
        // Hide the remove button if a default option is selected
        removeSexButton.style.display = "none";
    }
}

// Function to remove the selected custom Sex option
function removeSex() {
    var selectSex = document.getElementById("selectSex");
    var selectedValue = selectSex.value;

    if (selectedValue && selectedValue !== "male" && selectedValue !== "female" && selectedValue !== "Others") {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectSex.selectedIndex;
            selectSex.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById("removeSexButton").style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }


}
document.addEventListener('DOMContentLoaded', function() {
    const inputField = document.getElementById('datepicker');
    const errorDiv = inputField.nextElementSibling; // Assuming the error div is directly after the input field
    const regex = /^\d{1,2}[\/-]\d{1,2}[\/-]\d{4}$/; // Adjust regex pattern based on expected date format (e.g., dd/mm/yyyy or mm/dd/yyyy)

    function validateInput() {
        const value = inputField.value.trim();

        if (value === '') {
            // Empty field
            errorDiv.textContent = "Date of Interview is required.";
            errorDiv.style.display = 'block';
            inputField.classList.add('is-invalid');
            return false;
        } else if (!regex.test(value)) {
            // Invalid date format
            errorDiv.textContent = "Date of Interview must be in the format dd/mm/yyyy or mm/dd/yyyy.";
            errorDiv.style.display = 'block';
            inputField.classList.add('is-invalid');
            return false;
        } else {
            // Valid input
            errorDiv.style.display = 'none';
            inputField.classList.remove('is-invalid');
            return true;
        }
    }

    // Optional: Validate on input change
    inputField.addEventListener('input', validateInput);
});


document.addEventListener('DOMContentLoaded', function() {
    const dobInputField = document.getElementById('datepicker');
    const dobErrorDiv = dobInputField.nextElementSibling; // Assuming the error div is directly after the input field
    const regex = /^\d{1,2}[\/-]\d{1,2}[\/-]\d{4}$/; // Adjust regex pattern based on expected date format (e.g., dd/mm/yyyy or mm/dd/yyyy)

    function validateDateOfBirth() {
        const value = dobInputField.value.trim();

        if (value === '') {
            // Empty field
            dobErrorDiv.textContent = "Date of Birth is required.";
            dobErrorDiv.style.display = 'block';
            dobInputField.classList.add('is-invalid');
            return false;
        } else if (!regex.test(value)) {
            // Invalid date format
            dobErrorDiv.textContent = "Date of Birth must be in the format dd/mm/yyyy or mm/dd/yyyy.";
            dobErrorDiv.style.display = 'block';
            dobInputField.classList.add('is-invalid');
            return false;
        } else {
            // Valid input
            dobErrorDiv.style.display = 'none';
            dobInputField.classList.remove('is-invalid');
            return true;
        }
    }

    // Optional: Validate on input change
    dobInputField.addEventListener('input', validateDateOfBirth);
});


document.addEventListener('DOMContentLoaded', function() {
    const contactPersonInput = document.getElementById('contactPersonInput');
    const errorDiv = contactPersonInput.nextElementSibling; // Assuming the error div is directly after the input field
    const regex = /^[A-Za-z\s]*$/; // Allows letters and spaces, including empty

    function validateContactPerson() {
        const value = contactPersonInput.value.trim();

        if (value === '') {
            // Field is empty (valid case)
            errorDiv.style.display = 'none';
            contactPersonInput.classList.remove('is-invalid');
            return true;
        } else if (!regex.test(value)) {
            // Invalid symbols
            errorDiv.textContent = "Name of Contact Person should only contain letters and spaces.";
            errorDiv.style.display = 'block';
            contactPersonInput.classList.add('is-invalid');
            return false;
        } else {
            // Valid input
            errorDiv.style.display = 'none';
            contactPersonInput.classList.remove('is-invalid');
            return true;
        }
    }

    // Validate on input change
    contactPersonInput.addEventListener('input', validateContactPerson);
});

// Function to handle the Source of Capital selection
function checkSourceCapital() {
    var selectSourceCapital = document.getElementById("selectedSourceCapital");
    var removeSourceCapitalButton = document.getElementById("removeSourceCapitalButton");

    if (selectSourceCapital.value === "Others") {
        var newSourceCapital = prompt("Please enter the new Source of Capital:");

        if (newSourceCapital) {
            // Check if the option already exists
            var existingOption = Array.from(selectSourceCapital.options).find(option => option.value === newSourceCapital);

            if (!existingOption) {
                // Add the new option to the dropdown
                var newOption = document.createElement("option");
                newOption.text = newSourceCapital;
                newOption.value = newSourceCapital;
                selectSourceCapital.appendChild(newOption);
            }

            // Automatically select the new option
            selectSourceCapital.value = newSourceCapital;

            // Show the remove button
            removeSourceCapitalButton.style.display = "block";
        } else {
            // Hide the remove button if no value was entered
            removeSourceCapitalButton.style.display = "none";
        }
    } else {
        // Hide the remove button if a default option is selected
        removeSourceCapitalButton.style.display = "none";
    }
}

// Function to remove the selected Source of Capital (if it's not a default option)
function removeSourceCapital() {
    var selectSourceCapital = document.getElementById("selectedSourceCapital");
    var selectedValue = selectSourceCapital.value;

    if (selectedValue && selectedValue !== "Others" && !["Own", "Loan", "Financed"].includes(selectedValue)) {
        var confirmRemove = confirm("Are you sure you want to remove this option?");
        if (confirmRemove) {
            // Find the selected option and remove it
            var selectedIndex = selectSourceCapital.selectedIndex;
            selectSourceCapital.remove(selectedIndex);

            // Hide the remove button after removal
            document.getElementById("removeSourceCapitalButton").style.display = "none";
        }
    } else {
        alert("You cannot remove a default option.");
    }
}

function blockSymbolsAndNumbers(event) {
    const char = String.fromCharCode(event.which);
    const regex = /^[a-zA-Z\s]+$/;

    if (!regex.test(char)) {
        event.preventDefault();
        return false;
    }
}

function blockSymbolsAndNumbers(event) {
    const char = String.fromCharCode(event.which);
    const regex = /^[a-zA-Z\s]+$/;

    if (!regex.test(char)) {
        event.preventDefault();
        return false;
    }
}




$(document).ready(function() {
    $('#myForm').on('submit', function(e) {
        var dateInterview = $('#datepicker').val().trim();

        if (dateInterview === '') {
            e.preventDefault(); // Prevent form submission
            alert('Date of Interview cannot be empty.'); // Alert user
            $('#datepicker').focus(); // Optionally focus the field
        }
    });
});
$(document).ready(function() {
    $('#nextButton').on('click', function(event) {
        var dateOfInterview = $('#datepicker').val();

        if (!dateOfInterview) {
            event.preventDefault(); // Prevent form from submitting
            alert('Please fill out the Date of Interview field.');
            $('#datepicker').focus(); // Set focus to the field
        }
    });
});

// extenision modal
// document.addEventListener('DOMContentLoaded', function() {
//     const selectExtendName = document.getElementById('selectExtendName');
//     const customCloseButton = document.getElementById('customCloseButton');
//     const modalExtensionName = document.getElementById('modalExtensionName');
//     const modalSaveButton = document.getElementById('modalSaveButton');
//     const modalExtensionError = document.getElementById('modalExtensionError');
//     const removeExtendButton = document.getElementById('removeExtendButton');

//     // Show modal when "Others" is selected
//     selectExtendName.addEventListener('change', function() {
//         if (selectExtendName.value === 'others') {
//             $('#extensionModal').modal('show');
//         }
//     });
//     // Custom close button click event
//     customCloseButton.addEventListener('click', function() {
//         $('#extensionModal').modal('hide');
//     });

//     // Handle saving new extension name
//     modalSaveButton.addEventListener('click', function() {
//         const newExtension = modalExtensionName.value.trim();

//         if (newExtension === '' || !/^[A-Za-z\s]*$/.test(newExtension)) {
//             modalExtensionError.textContent = 'Please enter a valid extension name.';
//             modalExtensionName.classList.add('is-invalid');
//             return;
//         }

//         modalExtensionName.classList.remove('is-invalid');
//         modalExtensionError.textContent = '';

//         // Check if the extension already exists
//         const existingOption = Array.from(selectExtendName.options).find(option => option.value === newExtension);
//         if (existingOption) {
//             selectExtendName.value = newExtension;
//         } else {
//             // Add new extension to the select options
//             const newOption = document.createElement('option');
//             newOption.value = newExtension;
//             newOption.textContent = newExtension;
//             newOption.classList.add('new-extension'); // Add a class to identify new options
//             selectExtendName.appendChild(newOption);
//             selectExtendName.value = newExtension;

//             // Show the remove button for the new extension
//             removeExtendButton.style.display = 'inline-block';
//         }

//         // Close the modal
//         $('#extensionModal').modal('hide');
//     });

//     // Handle removal of new extension
//     removeExtendButton.addEventListener('click', function() {
//         const selectedOption = selectExtendName.options[selectExtendName.selectedIndex];
//         if (selectedOption && selectedOption.classList.contains('new-extension')) {
//             selectExtendName.removeChild(selectedOption);
//             removeExtendButton.style.display = 'none'; // Hide the button again
//         }
//     });

//     // Update the remove button visibility based on selection
//     selectExtendName.addEventListener('change', function() {
//         if (selectExtendName.value !== 'others') {
//             const selectedOption = selectExtendName.options[selectExtendName.selectedIndex];
//             removeExtendButton.style.display = selectedOption && selectedOption.classList.contains('new-extension') ? 'inline-block' : 'none';
//         }
//     });
// });

document.addEventListener('DOMContentLoaded', function() {
    const selectExtendName = document.getElementById('selectExtendName');
    const modalExtensionName = document.getElementById('modalExtensionName');
    const modalSaveButton = document.getElementById('modalSaveButton');
    const modalExtensionError = document.getElementById('modalExtensionError');
    const removeExtendButton = document.getElementById('removeExtendButton');

    // Show modal when "Others" is selected
    selectExtendName.addEventListener('change', function() {
        if (selectExtendName.value === 'others') {
            var myModal = new bootstrap.Modal(document.getElementById('extensionModal'));
            myModal.show();
        }
    });

    // Handle saving new extension name
    modalSaveButton.addEventListener('click', function() {
        const newExtension = modalExtensionName.value.trim();

        if (newExtension === '' || !/^[A-Za-z\s]*$/.test(newExtension)) {
            modalExtensionError.textContent = 'Please enter a valid extension name.';
            modalExtensionName.classList.add('is-invalid');
            return;
        }

        modalExtensionName.classList.remove('is-invalid');
        modalExtensionError.textContent = '';

        // Check if the extension already exists
        const existingOption = Array.from(selectExtendName.options).find(option => option.value === newExtension);
        if (existingOption) {
            selectExtendName.value = newExtension;
        } else {
            // Add new extension to the select options
            const newOption = document.createElement('option');
            newOption.value = newExtension;
            newOption.textContent = newExtension;
            newOption.classList.add('new-extension'); // Add a class to identify new options
            selectExtendName.appendChild(newOption);
            selectExtendName.value = newExtension;

            // Show the remove button for the new extension
            removeExtendButton.style.display = 'inline-block';
        }

        // Close the modal
        var myModal = bootstrap.Modal.getInstance(document.getElementById('extensionModal'));
        myModal.hide();
    });

    // Handle removal of new extension
    removeExtendButton.addEventListener('click', function() {
        const selectedOption = selectExtendName.options[selectExtendName.selectedIndex];
        if (selectedOption && selectedOption.classList.contains('new-extension')) {
            selectExtendName.removeChild(selectedOption);
            removeExtendButton.style.display = 'none'; // Hide the button again
        }
    });

    // Update the remove button visibility based on selection
    selectExtendName.addEventListener('change', function() {
        if (selectExtendName.value !== 'others') {
            const selectedOption = selectExtendName.options[selectExtendName.selectedIndex];
            removeExtendButton.style.display = selectedOption && selectedOption.classList.contains('new-extension') ? 'inline-block' : 'none';
        } else {
            removeExtendButton.style.display = 'none'; // Hide if "Others" is selected
        }
    });
});