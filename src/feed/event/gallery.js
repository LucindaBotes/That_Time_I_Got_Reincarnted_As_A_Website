export const uploadPicture = async (file) => {
  if(!['image/jpeg', 'image/png'].includes(file.type))
    {
      document.getElementsByName('eventImage')[0].value = '';
      return;
    }
    if(file.size > 2 * 1024 * 1024)
    {
      document.getElementsByName('eventImage')[0].value = '';
      return;
    }
  const user = JSON.parse(sessionStorage.getItem('user'));
  const form_data = new FormData();
  form_data.append('userId', user.id);
  form_data.append('eventImage', file);
  
  fetch(
    '../../../php/images/uploadImage.php', {
      method: 'POST',
      body: form_data
    }
  )
  .then(function(response){
    return response.json();
  }).then(function(responseData){
    document.getElementsByName('eventImage')[0].value = '';
  });
}

export const getImages = async (eventId) => {
  const res = await fetch(
    '../../../php/images/getImages.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        eventId: eventId
      })
    }
  );
  if (res.status === 200) {
    const data = await res.json();
    return data.data;
  }
}
