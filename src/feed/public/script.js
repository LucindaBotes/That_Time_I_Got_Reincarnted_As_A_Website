import { EventCard } from "../../models/EventCard.js";
import { getReviews, reviewEvent } from "../event/review.js";
import { getImages, uploadPicture } from "../event/gallery.js";

export const fetchEvent = async () => {
  const content = document.getElementById("content");
  const user = JSON.parse(sessionStorage.getItem('user'));
  
  fetch(
    '../../../php/events/getAllEvents.php', {
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
        // if result.data is empty, display a message
        if (result.data.length === 0) {
          content.innerHTML = `<h1 class="noEvents">No quests to display</h1>`;
        } else {
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
              const reviewDropdown = document.getElementById("reviewDropdown");
              const reviewBody = document.getElementById("review-body");
              const reviewDD = document.getElementById("review-dd"); 
              const reviewSubmit = document.getElementById("new-review");
              const gallerySubmit = document.getElementById("gallery-submit");
              const galleryDropdown = document.getElementById("galleryDropdown");
              const galleryDD = document.getElementById("gallery-dd");
              const galleryBody = document.getElementById("gallery-body");

              gallerySubmit.onsubmit = (e) => {
                e.preventDefault();
                const file = document.getElementById('gallery-input')[0].files[0];
                uploadPicture(file).then(() => {
                  getImages(result.data[i].id);
                });
              }

              galleryDropdown.addEventListener("click", () => {
                galleryDD.innerHTML = '';
                galleryBody.classList.toggle("hidden");
                getImages(result.data[i].id).then((images) => {
                  images.imagePaths.forEach((image) => {
                    const imagePath = image.slice(9);
                    const path = `../../../${imagePath}`;
                    galleryDD.innerHTML += `<img class='gallery col-3' src="${path}">`;
                  });
                });
              });

              reviewSubmit.onsubmit = (e) => {
                const newReview = document.getElementById("review-input").value;
                e.preventDefault();
                reviewEvent(result.data[i].id, newReview).then(() => {
                  getReviews(result.data[i].id);
                });
              };
              reviewDropdown.addEventListener("click", (e) => {
                reviewDD.innerHTML = "";
                reviewBody.classList.toggle("hidden");
                e.preventDefault();
                getReviews(result.data[i].id).then((reviews) => {
                  reviews.forEach((review) => {
                    reviewDD.innerHTML += `<a id="review-${review[0].id}" class="dropdown-item">${review[0].rText}</a>`;
                  });
                });
              });
              // add event listener to close-modal button to close modal
              modalTitle.innerHTML = result.data[i].title;
              modalDescription.innerHTML = result.data[i].description;
              modalDate.innerHTML = `<img class="locationIcon" src="../../../assets/images/date.png" alt="">` +  result.data[i].date;
              modalLocation.innerHTML = `<img class="locationIcon" src="../../../assets/images/location.png" alt="">` +  result.data[i].location;
              modalLevel.innerHTML = result.data[i].level + "-Tier";
              modalReward.innerHTML = result.data[i].reward + "g";
              const closeModal = document.getElementById("close-modal-event");
              closeModal.addEventListener("click", () => {
                modal.style.display = 'none';
              });
            });
          })
        }
      })
    }
  })
}

export const fetchReviews = async (eventId) => {
  fetch(
    '../../../php/events/getReviews.php', {
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

const myModal = document.getElementById('addEvent');
const myAdventureModal = document.getElementById('addAdventure');
const myGroupModal = document.getElementById('addGroup');
const options = document.querySelectorAll(".plus");
const adventure = document.getElementById("adventure");
const groupModal = document.getElementById("groupModal");
const section = document.getElementById('section');
const addButton = document.getElementById("plus-main");
const closeModal = document.getElementById("closeModal");
const closeAdventureModal = document.getElementById("closeAdventureModal");
const closeGroupModal = document.getElementById("closeGroupModal");

closeModal.addEventListener("click", () => {
  myModal.classList.add('hidden');
  myModal.classList.remove('customModal');
  section.classList.add('hidden');
});

closeAdventureModal.addEventListener("click", () => {
  myAdventureModal.classList.add('hidden');
  myAdventureModal.classList.remove('customModal');
  adventure.classList.add('hidden');
});

closeGroupModal.addEventListener("click", () => {
  myGroupModal.classList.add('hidden');
  myGroupModal.classList.remove('customModal');
  groupModal.classList.add('hidden');
});

addButton.addEventListener("click", (e) => {
  e.preventDefault();
  addButton.removeEventListener("click", (e) => {});
  
  options.forEach((option) => {
    // check if the option is hidden
    if (!option.classList.contains("visible")) {
      option.classList.add("visible");
      option.addEventListener("click", (e) => {
        if (e.target.id === "event") {
          myModal.classList.remove('hidden');
          myModal.classList.add('customModal');
          section.classList.remove('hidden');
          section.addEventListener('click', (e) => {
            if (e.target.id === 'section') {
              myModal.classList.add('hidden');
              myModal.classList.remove('customModal');
              section.classList.add('hidden');
            }
          });
        } 
        if (e.target.id === "list") {
          myAdventureModal.classList.remove('hidden');
          myAdventureModal.classList.add('customModal');
          adventure.classList.remove('hidden');
          adventure.addEventListener('click', (e) => {
            if (e.target.id === 'adventure') {
              console.log("adventure");
              myAdventureModal.classList.add('hidden');
              myAdventureModal.classList.remove('customModal');
              adventure.classList.add('hidden');
            }
          });
        }
        
        if (e.target.id === "group") {
          myGroupModal.classList.remove('hidden');
          myGroupModal.classList.add('customModal');
          groupModal.classList.remove('hidden');
          groupModal.addEventListener('click', (e) => {
            if (e.target.id === 'groupModal') {
              console.log("group");
              myGroupModal.classList.add('hidden');
              myGroupModal.classList.remove('customModal');
              groupModal.classList.add('hidden');
            }
          });
        }
      });
    } else {
      option.classList.remove("visible");
    }
  });
});

const privateButton = document.getElementById("private");
privateButton.addEventListener("click", (e) => {
  window.location.href = "../private/";
});

const publicButton = document.getElementById("public");
publicButton.addEventListener("click", (e) => {
  window.location.href = "../public/";
});
