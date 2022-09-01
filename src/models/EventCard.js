export class EventCard {
  constructor(raw) {
    this.raw = raw;
  }

  clean() {
    return {
      image: "../../../assets/images/placeholderImage.jpg",
      title: this.raw.ename,
      description: this.raw.description,
      date: new Date(this.raw.date).toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"}),
      location: this.raw.location,
      level: this.raw.level,
      reward: this.raw.reward
    };
  }

  render() {
    const {image, title, description, date, location, level, reward } =
      this.clean();
    return `
        <div class="card" style="width: 18rem;">
        <img src="${image}" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">${title}</h5>
          <p class="card-text">${description}</p>
          <p class="card-text"><small class="text-muted">${date}</small></p>
          <p class="card-text"><small class="text-muted">${location}</small></p>
          <p class="card-text"><small class="text-muted">${level}</small></p>
          <p class="card-text"><small class="text-muted">${reward}</small></p>
        </div>
    `;
  }
}