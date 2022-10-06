import { EventCard } from "../../models/EventCard.js";
export const fetchEvent = async () => {
  const content = document.getElementById("content");
  const user = JSON.parse(sessionStorage.getItem('user'));
  
  fetch(
    '../../../php/events/getEvents.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        userId: user.id
      })
    }
  ).then((res) => {
    if (res.status === 200) {
      res.json().then((result) => {
        result.data?.map(event => {
          content.innerHTML += new EventCard(event).render();
        });
        // get each eventCard and add an event listener to it
        const eventCards = document.querySelectorAll('.padd');
        eventCards.forEach((eventCard, i) => {
          const modal = document.getElementById("modal");
          eventCard.addEventListener("click", () => {
            modal.style.display = 'block';
            const modalTitle = document.getElementById("modal-title");
            const modalDescription = document.getElementById("modal-description");
            const modalDate = document.getElementById("modal-date");
            const modalLocation = document.getElementById("modal-location");
            const modalLevel = document.getElementById("modal-level");
            const modalReward = document.getElementById("modal-reward");
            // add event listener to close-modal button to close modal
            modalTitle.innerHTML = result.data[i].ename;
            modalDescription.innerHTML = result.data[i].event_description;
            modalDate.innerHTML = `<img class="locationIcon" src="../../../assets/images/date.png" alt="">` +  result.data[i].event_date;
            modalLocation.innerHTML = `<img class="locationIcon" src="../../../assets/images/location.png" alt="">` +  result.data[i].event_location;
            modalLevel.innerHTML = result.data[i].level_requirement + "-Tier";
            modalReward.innerHTML = result.data[i].reward + "g";
            const closeModal = document.getElementById("close-modal-event");
            closeModal.addEventListener("click", () => {
              modal.style.display = 'none';
            });
          });
        })
      })
    }
  })
}

// Make a fetch request to the server to get the reviews for the current event
export const fetchReviews = async (eventId) => {
  fetch(
    '../../../php/reviews/getReviews.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        eventId: eventId
      })
    }
  ).then((res) => {
    if (res.status === 200) {
      res.json().then((data) => {
        data.data?.map(review => {
          const reviewCard = new ReviewCard(review).render();
          const body = document.getElementById("body");
          content.innerHTML += reviewCard;
          const reviewCards = document.querySelectorAll(".reviewCard");
          reviewCards.forEach((card) => {
            card.addEventListener("click", (e) => {
              modal.style.display = 'block';
              const modalInfo = new ReviewModal(review).render();
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