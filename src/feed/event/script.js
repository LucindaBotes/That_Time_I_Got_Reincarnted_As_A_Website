export const createEvent = async () => {
  
  const title = document.getElementById('eventTitle').value;
  const description = document.getElementById('eventDescription').value;
  const date = document.getElementById('eventDate').value;
  const location = document.getElementById('eventLocation').value;
  const level = document.getElementById('eventLevel').value;
  const reward = document.getElementById('eventReward').value;

  const newDate = new Date(date);
  // Set to a loading state
  fetch(
    '/IMY220/project/php/events/createEvent.php', {
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
        reward: reward
      })
    }
  )
  .then((res) => {
    if(res.status === 201) {
      window.location.href = "/IMY220/project/src/feed/public/";
    }
  })
  .catch(err => 
    document.getElementById("errorMessage").innerHTML = err
  );
}

// new SANews(rawArticle).render()
// content.innerHTML = "";
// formattedArticles.forEach((article) => content.appendChild(article));