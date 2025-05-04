function addFavorite() {
  const fav = document.getElementById("new-fav").value.trim();
  if (fav === "") return;
  fetch("api/update_data.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "type=favorites&append=true&value=" + encodeURIComponent(fav)
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === "success") {
      const li = document.createElement("li");
      li.textContent = fav;
      document.getElementById("fav-list").appendChild(li);
      document.getElementById("new-fav").value = "";
    }
  });
}
