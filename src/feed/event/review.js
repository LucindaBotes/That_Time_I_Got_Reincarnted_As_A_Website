export const getReviews = async (eventId) => {
  const res = await fetch(
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
  );
  if (res.status === 200) {
    const data = await res.json();
    return data.data;
  }
};

export const reviewEvent = async (eventId, review) => {
  const user = JSON.parse(sessionStorage.getItem('user'));
  console.log(user.id);
  const res = await fetch(
    '../../../php/events/reviewEvent.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        eventId: eventId,
        review: review,
        userId: user.id
      })
    }
  );
  if (res.status === 200) {
    const data = await res.json();
    return data.data;
  }
};