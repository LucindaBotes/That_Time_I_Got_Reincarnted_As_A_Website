export class EventCard {
  constructor(raw) {
    this.raw = raw;
  }

  clean() {
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
      <div id="eventCard-${id}" class="padd col-3 eventCard" style="max-height: 300px">
        <div class="card-deck" style="background-image: url('${image}'); background-size: cover; background-repeat: no-repeat; height: 300px; position: relative" >
          <div class="event-card">
              <h5 class="title">${title}</h5>
              <small class="date-time">${date} @${time}</small>
              <div class="tags">
                <small class="tag gold">${reward} gold</small>
                <small class="tag level">${level}-Tier</small>
              </div>
              <div class="d-flex ml-auto">
                <img class="pin" src="../../../assets/images/location.png" alt="pin">
                <p class="place"><small class="text-muted">${location}</small></p>
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