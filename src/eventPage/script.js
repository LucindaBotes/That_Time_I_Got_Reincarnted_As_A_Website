export const upload_image = (file) => {

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
  const user = JSON.parse(sessionStorage.getItem('user'));

    form_data.append('sample_image', file);
    form_data.append('userId', user.id);

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
}