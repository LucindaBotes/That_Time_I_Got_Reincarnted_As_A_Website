// groupName
export const createGroup = async () => {
  
  const groupName = document.getElementById('groupTitle').value;
  const user = JSON.parse(sessionStorage.getItem('user'));

  fetch(
    '../../../php/groups/createGroup.php', {
      method: 'POST',
      body: JSON.stringify({
        groupName: groupName,
        userId: user.id
      })
    }
  )
  .then(function(response){
    console.log(response);
    return response.json();
  })
}
