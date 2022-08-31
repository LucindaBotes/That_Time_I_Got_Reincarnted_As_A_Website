export const login = async (name, pass) => {
  console.log("Login");
  // Set to a loading state
  fetch(
    '/IMY220/project/php/login/login.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        name: name,
        password: pass
      })
    }
  )
    .then((res) => console.log(res))
    .catch(err => console.log(err));
}