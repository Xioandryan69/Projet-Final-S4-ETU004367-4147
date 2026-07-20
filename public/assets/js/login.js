function ajax(url, form, callback) {
  const formData = new FormData(form);

  fetch(url, {
    method: "POST",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
    },
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      callback(data);
    })
    .catch((error) => {
      console.error("Erreur AJAX:", error);
      const errorElement = document.getElementById("login_error");
      if (errorElement) {
        errorElement.innerHTML = "Erreur serveur";
      }
    });
}
function login(url, idForm) {
  const form = document.getElementById(idForm);

  ajax(url, form, (data) => {
    if (data.success) {
      window.location.href = data.redirect;
    } else {
      const errorElement = document.getElementById("login_error");

      if (errorElement) {
        errorElement.innerHTML = data.errors || "Erreur de connexion";
      }
    }
  });
}
