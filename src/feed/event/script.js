export const createEvent = async (file) => {
  
  const title = document.getElementById('eventTitle').value;
  const description = document.getElementById('eventDescription').value;
  const date = document.getElementById('eventDate').value;
  const monster = document.getElementById('monsterList').value;
  const reward = document.getElementById('eventReward').value;
  console.log(monster);
  const newDate = new Date(date).toISOString().split('T')[0];
  const time = document.getElementById('eventTime').value;
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
      form_data.append('title', title);
      form_data.append('description', description);
      form_data.append('date', newDate);
      form_data.append('time', time);
      form_data.append('monster', monster);
      form_data.append('reward', reward);
      form_data.append('userId', user.id);
      form_data.append('eventImage', file);

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

export const getMonsters = async () => {
  fetch(
    '../../../php/events/getMonsters.php',
    {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        userId: JSON.parse(sessionStorage.getItem('user')).id
      })
    }
  ).then(function(response){
    return response.json();
  }).then(function(responseData){
    console.log(responseData);
    const monsters = responseData.data;
    let monsterList = document.getElementById('monsterList');
    monsters.forEach(monster => {
      const monsterItem = `<option value='${monster.id}'> ${monster.mName} </option>`;
      monsterList.innerHTML += monsterItem;
    });
  });
}

