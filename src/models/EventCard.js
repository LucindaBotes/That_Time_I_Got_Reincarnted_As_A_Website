export class EventCard {
  constructor(raw) {
    this.raw = raw;
  }

  clean() {
    console.log(this.raw.description);
    return {
      id: this.raw.id,
      image: this.raw.event_thumbnail ? this.raw.event_thumbnail : "../../../gallery/placeholderImage.jpg",
      title: this.raw.title,
      date: new Date(this.raw.date).toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"}),
      time: this.raw.time,
      description: this.raw.description,
      location: this.raw.location,
      level: this.raw.level,
      reward: this.raw.reward
    };
  }

  render() {
    const {id, image, title, description, date, time, location, level, reward } =
      this.clean();
    return `
      <div id="eventCard-${id}" class="padd col-4 eventCard" data-toggle="modal" data-target="#exampleModal">
        <div class="card-deck">
          <div class="m-2">
            <img src="${image}" class="card-img-top" alt="...">
            <div class="card-body p-2">
              <h5 class="card-title">${title}</h5>
              <p class="card-text m-0">${description}</p>
              <div class="flex-row d-flex justify-content-between">
                <p class="card-text m-0"><small class="text-muted">${date} @${time}</small></p>
                <p class="card-text m-0"><small class="text-muted">${location}</small></p>
              </div>
              <div class="flex-row d-flex justify-content-between">
                <p class="card-text m-0"><small class="text-muted">${level}-Tier</small></p>
                <p class="card-text m-0"><small class="text-muted">${reward} gold</small></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;
  }
}

/**
 * {
            "id": 45,
            "title": "Epic Cat Hunt",
            "description": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
            "date": "2022-10-27",
            "time": "12:40:00",
            "location": "Sevrend, Mournstead",
            "level": "SS",
            "reward": 1,
            "monster": "Cat",
            "event_thumbnail": "..\/..\/gallery\/1666867266.png"
        }} eventId 
 */