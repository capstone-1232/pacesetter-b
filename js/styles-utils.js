console.log("js connected");

let searchBtn = document.getElementById("show-search");

searchBtn.addEventListener("click", () => {
    document.getElementById("main-search").classList.toggle("hidden");
});