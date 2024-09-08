
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<form  id="form">
 
<!-- Farm Info Section -->
<div class="farmer-info">
    <label>Farm status:</label>
    <input type="text" name="first_name">
</div>

<div class="farm-info">
    <label>Farmer id:</label>
    <input type="number" name="personal_informations_id" >
</div>
<br>
    <div class="crop">
      <label>Crop </label>
      <input type="test" name="crop[]">
    </div>
    
    <br>
    
    <div class="crop">
      <label>Crop </label>
      <input type="test" name="crop[]">
    </div>
    
    <br>

    <div class="crop">
      <label>Crop </label>
      <input type="test" name="crop[]">
    </div>
    
    <hr>
    
    <button type="submit">Submit</button>
    
  </form>

  <script>


// Assuming you have a form with the ID 'form'
const form = $('#form');

console.log(2)

// Bind the submit event to the form
form.on('submit', function(event) {
    event.preventDefault(); // Prevent the form from reloading the page
  

        // Gather farmer info from the form inputs
        let farmerInfo = {
            'first_name': $('input[name="first_name"]').val()
          
      
        };

        // Gather farm info from the form inputs
        let farmInfo = {
    'tenurial_status': $('input[name="tenurial_status"]').val(),
    'personal_informations_id': $('input[name="personal_informations_id"]').val()
};

    

            // Gather crop info from the form inputs
            let cropInfo = [];

$('.crop input[name="crop[]"]').each(function() {
    cropInfo.push({
        crop_name: $(this).val()
    });
});
// console.log("Farmer Info:", farmerInfo); // Display the gathered farmer info in the console
// console.log("Farm Info:", farmInfo); // Display the gathered farm info in the console
// console.log("Crops entered so far:", cropInfo); // Display the gathered crops in the console
// });

    let dataobject = {
        'farmer': farmerInfo, 
        'farm': farmInfo,
        'crops': cropInfo
    }
   // Log the entire data object to the console
   console.log("Data Object:", dataobject);
});
    // const csrfToken = $('input[name="_token"]').attr('value');

//     //   Send the AJAX request
//     $.ajax({
//         url: '/admin-view-Farmers-samplefolder',
//         method: 'POST',
//         contentType: 'application/json', // Set content type for JSON
//         data: JSON.stringify(dataobject), // Attach the prepared data here
//         headers: {
//           'X-CSRF-TOKEN': csrfToken // Include the CSRF token in the headers
//         },
//         success: function(response) {

//           if(response.success) {
//             console.log(response);
//             console.log(response.success);
//           }



//         },
//         error: function(error) {
//           console.error('Error:', error.responseJSON.message);
//         }
//     });
// });

  </script>

