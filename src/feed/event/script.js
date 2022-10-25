export const createEvent = async () => {
  
  const title = document.getElementById('eventTitle').value;
  const description = document.getElementById('eventDescription').value;
  const date = document.getElementById('eventDate').value;
  const location = document.getElementById('eventLocation').value;
  const level = document.getElementById('eventLevel').value;
  const reward = document.getElementById('eventReward').value;
  const newDate = new Date(date).toISOString().split('T')[0];
  const image = document.getElementById('eventImage').files[0];


  // ------------------------------------Thumbnail Image------------------------------------
  if(!['image/jpeg', 'image/png'].includes(file.type))
	{
		document.getElementById('uploaded_image').innerHTML = '<div class="alert alert-danger">Only .jpg and .png image are allowed</div>';

		document.getElementsByName('sample_image')[0].value = '';

		return;
	}

	if(file.size > 2 * 1024 * 1024)
	{
		document.getElementById('uploaded_image').innerHTML = '<div class="alert alert-danger">File must be less than 2 MB</div>';

		document.getElementsByName('sample_image')[0].value = '';

		return;
	}

  const form_data = new FormData();

    form_data.append('sample_image', file);

    fetch("../../php/images/uploadImage.php", {
    	method:"POST",
    	body : form_data,
    }).then(function(response){
      console.log(response);
    	return response.json();
    }).then(function(responseData){
      console.log(responseData.data.imagePath);
    	document.getElementById('uploaded_image').innerHTML = '<div class="alert alert-success">Image Uploaded Successfully</div> <img src="'+responseData.data.imagePath+'" class="img-thumbnail" />';

    	document.getElementsByName('sample_image')[0].value = '';

    });
  // Set to a loading state
  const user = JSON.parse(sessionStorage.getItem('user'));
  fetch(
    '../../../php/events/createEvent.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        title: title,
        description: description,
        date: newDate,
        location: location,
        level: level,
        reward: reward,
        userId: user.id,
        event_image: image
      })
    }
  )
  .then((res) => {
    console.log(title);
    if(res.status === 201) {
      window.location.href = "../public/";
    }
  })
  .catch(err => 
    document.getElementById("errorMessage").innerHTML = err
  );
}
