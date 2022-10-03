export class EventCard {
  constructor(raw) {
    this.raw = raw;
  }

  clean() {
    console.log(this.raw.description);
    return {
      image: "../../../assets/images/placeholderImage.jpg",
      title: this.raw.ename,
      date: new Date(this.raw.event_date).toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"}),
      description: this.raw.event_description,
      location: this.raw.event_location,
      level: this.raw.level_requirement,
      reward: this.raw.reward
    };
  }

  render() {
    const {image, title, description, date, location, level, reward } =
      this.clean();
    return `
      <div class="col-3">
        <div class="card-deck">
          <div class="card m-2">
          <img src="${image}" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">${title}</h5>
            <p class="card-text m-0">${description}</p>
            <div class="flex-row d-flex justify-content-between">
              <p class="card-text m-0"><small class="text-muted">${date}</small></p>
              <p class="card-text m-0"><small class="text-muted">${location}</small></p>
            </div>
            <div class="flex-row d-flex justify-content-between">
              <p class="card-text m-0"><small class="text-muted">${level}</small></p>
              <p class="card-text m-0"><small class="text-muted">${reward}</small></p>
            </div>
          </div>
        </div>
      </div>
    `;
  }
}