function addFavorite() {
  const favInput = document.getElementById("new-fav");
  const fav = favInput.value.trim();
  if (!fav) return;

  fetch("api/update_data.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "type=favorites&append=true&value=" + encodeURIComponent(fav)
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === "success") {
      const li = document.createElement("li");
      li.className = "list-group-item";
      li.textContent = fav;
      document.getElementById("fav-list").appendChild(li);
      favInput.value = "";
      showToast("✅ '" + fav + "' added to your favorites!");
    }
  });
}

function showToast(message) {
  const toastBody = document.getElementById("toast-body");
  toastBody.textContent = message;
  const toastEl = document.getElementById("toast");
  const toast = new bootstrap.Toast(toastEl);
  toast.show();
}
