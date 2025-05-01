const a_logout = document.getElementById("logout");
const form_logout = document.querySelector(".form_logout");

document.addEventListener("click", (event) => {
    const isClickInside =
        form_logout.contains(event.target) || event.target === a_logout;
    form_logout.classList.toggle("d-none", !isClickInside);
});
