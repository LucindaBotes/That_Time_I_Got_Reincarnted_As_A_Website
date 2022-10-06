import { EventCard } from "../../models/EventCard.js";
export const fetchEvent = async () => {
  const content = document.getElementById("content");

  fetch(
    '../../../php/events/getEvents.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        userId: sessionStorage.getItem('userId')
      })
    }
  ).then((res) => {
    if (res.status === 200) {
      res.json().then((data) => {
        data.data?.map(event => {
          const eventCard = new EventCard(event).render();
          content.innerHTML += eventCard;
        })
      })
    }
  })
}


export const showModal = () => {
  const modal = document.getElementById("exampleModal");
  const modalTitle = document.getElementById("exampleModalLabel");
  const modalBody = document.getElementById("modal-body");
  const modalFooter = document.getElementById("modal-footer");
  const eventCards = document.querySelectorAll("#eventCard");
  eventCards.forEach(eventCard => {
    eventCard.addEventListener("click", () => {
      modalTitle.innerHTML = eventCard.querySelector(".card-title").innerHTML;
      modalBody.innerHTML = eventCard.querySelector(".card-text").innerHTML;
      modalFooter.innerHTML = eventCard.querySelector(".card-text").innerHTML;
    })
  })
}