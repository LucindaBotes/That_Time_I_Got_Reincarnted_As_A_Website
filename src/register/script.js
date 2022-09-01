export const register = async () => {
  
  const name = document.getElementById('name').value;
  const pass = document.getElementById('password').value;

  // Set to a loading state
  fetch(
    '/IMY220/project/php/register/register.php', {
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
    if(res.status === 201) {
      window.location.href = "/IMY220/project/src/profile/";
    }
  })
  .catch(err => 
    document.getElementById("errorMessage").innerHTML = err
  );
}