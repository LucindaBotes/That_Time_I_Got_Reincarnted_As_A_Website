export const createEvent = async (file) => {
  
  const title = document.getElementById('eventTitle').value;
  const description = document.getElementById('eventDescription').value;
  const date = document.getElementById('eventDate').value;
  const location = document.getElementById('eventLocation').value;
  const level = document.getElementById('eventLevel').value;
  const reward = document.getElementById('eventReward').value;
  const newDate = new Date(date).toISOString().split('T')[0];
  const time = document.getElementById('eventTime').value;
      if(!['image/jpeg', 'image/png'].includes(file.type))
      {
        // document.getElementById('uploaded_image').innerHTML = '<div class="alert alert-danger">Only .jpg and .png image are allowed</div>';
        document.getElementsByName('eventImage')[0].value = '';
        return;
      }
      if(file.size > 2 * 1024 * 1024)
      {
        // document.getElementById('uploaded_image').innerHTML = '<div class="alert alert-danger">File must be less than 2 MB</div>';
        document.getElementsByName('eventImage')[0].value = '';
        return;
      }
      const user = JSON.parse(sessionStorage.getItem('user'));
      const form_data = new FormData();
      form_data.append('title', title);
      form_data.append('description', description);
      form_data.append('date', newDate);
      form_data.append('time', time);
      form_data.append('level', level);
      form_data.append('reward', reward);
      form_data.append('userId', user.id);
      form_data.append('eventImage', file);

  // ------------------------------------Thumbnail Image------------------------------------
  
  fetch(
    '../../../php/events/createEvent.php', {
      method: 'POST',
      body: form_data
    }
  )
  .then(function(response){
    console.log(response);
    window.location.href = '../public/';
    return response.json();
  }).then(function(responseData){
    console.log(responseData.data.imagePath);
    document.getElementsByName('eventImage')[0].value = '';
  });
}

