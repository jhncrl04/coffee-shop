const productCards = document.querySelectorAll(".card.product");
const isLogin = document.getElementById("isLogin");

productCards.forEach((card) => {
  card.addEventListener("click", (e) => {
    alert("You must log in before ordering");

    show_modal(logInModal);
  });
});
