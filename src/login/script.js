export const login = async () => {

  const name = document.getElementById('loginName').value;
  const pass = document.getElementById('loginPass').value;
  // Set to a loading state
  fetch(
      '../../php/login/login.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify({
          name: name,
          password: pass
        })
      }
    )
    .then((res) => {
      if (res.status === 200) {
        res.json().then((data) => {
            sessionStorage.setItem('user', JSON.stringify(data.data));
            window.location.href = "../feed/private/";
        });
      }
    })
    .catch(err =>
      document.getElementById("errorMessage").innerHTML = err
    );
}