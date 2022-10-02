import { EventCard } from "../../models/EventCard.js";
export const fetchEvent = async () => {
  const content = document.getElementById("content");

  fetch(
    '../../php/events/getEvents.php', {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
    }
  ).then((res) => {
    res.json().then((data) => {
      if (res.status === 200) {
        console.log(data);
        data.data?.map(event => {
          const eventCard = new EventCard(event).render();
          content.innerHTML += eventCard;
        })
      }
    })
  })
}