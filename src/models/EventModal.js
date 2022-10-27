export class EventCard {
  constructor(raw) {
    this.raw = raw;
  }

  clean() {
    console.log(this.raw.description);
    return {
      image: "../../../assets/images/placeholderImage.jpg",
      title: this.raw.eName,
      date: new Date(this.raw.eDate).toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"}),
      description: this.raw.eDescription,
      location: this.raw.eLocation,
      level: this.raw.eLevel,
      reward: this.raw.eReward
    };
  }

  render() {
    const {image, title, description, date, location, level, reward } =
      this.clean();
    return `
    `;
  }
}