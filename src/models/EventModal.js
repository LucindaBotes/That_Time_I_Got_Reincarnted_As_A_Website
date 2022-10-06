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
    `;
  }
}