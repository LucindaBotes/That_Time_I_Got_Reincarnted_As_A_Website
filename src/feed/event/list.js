export const createList = async () => {
  
  const listName = document.getElementById('adventureTitle').value;
  const user = JSON.parse(sessionStorage.getItem('user'));

  fetch(
    '../../../php/events/createEventList.php', {
      method: 'POST',
      body: JSON.stringify({
        listName: listName,
        userId: user.id
      })
    }
  )
  .then(function(response){
    console.log(response);
    return response.json();
  }).then(function(responseData){
    console.log(responseData.data.imagePath);
    document.getElementsByName('eventImage')[0].value = '';
  });
}
