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
          const eventCards = document.querySelectorAll(".eventCard");
          eventCards.forEach((card) => {
            card.addEventListener("click", () => {
              console.log("Click is working");
              showModal(card);
            });
          });
        })
      })
    }
  })
}


export const showModal = (eventCard) => {
  const modal = document.getElementById("exampleModalRight");
  const modalTitle = document.getElementById("exampleModalLabel");
  const modalBody = document.querySelectorAll("modal-body")[0];
  const modalFooter = document.querySelectorAll("modal-footer")[0];
  const cardtext = eventCard.querySelectorAll(".card-text");
  modalTitle.innerHTML = eventCard.querySelector(".card-title").innerHTML;
  cardtext.forEach((text) => {
    console.log(modalBody);
    modalBody.innerHTML += text.innerHTML;
  });
}