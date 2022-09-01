export const login = async () => {
  
  const name = document.getElementById('loginName').value;
  const pass = document.getElementById('loginPass').value;
  // Set to a loading state
  fetch(
    '/IMY220/project/php/login/login.php', {
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
    if(res.status === 200) {
      window.location.href = "/IMY220/project/src/feed/public/";
    }
  })
  .catch(err => 
    document.getElementById("errorMessage").innerHTML = err
  );
}