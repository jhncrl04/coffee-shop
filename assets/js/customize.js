const totalPrice = document.getElementById("total-price");

const sizesBtn = document.querySelectorAll(".cup-container .size");

const maskContainer = document.querySelector(".masked-image");

const cupImages = document.querySelectorAll(".customize-preview .cup");
const whippedCreamImages = document.querySelectorAll(".whipped-cream");
const toppingsImages = document.querySelectorAll(
  ".customize-preview .toppings"
);
const flavorImages = document.querySelectorAll(".customize-preview .flavor");
const addonsImages = document.querySelectorAll(".customize-preview .add-ons");

const customizeInfo = {
  cupSize: "",
  toppings: "",
  "whipped-cream": "",
  flavor: "",
  addons: [],
};

let drinkTotalPrice = 0.0;

let cupPrice = 0.0;
let flavorPrice = 0.0;
let toppingsPrice = 0.0;
let whippedCreamPrice = 0.0;
let addonsPrice = 0.0;

sizesBtn.forEach((size) => {
  size.addEventListener("click", () => {
    customizeInfo["cupSize"] = size.value;
    cupPrice = parseFloat(size.dataset.price);

    updateDrinkPrice();

    cupImages[1].style.opacity = 0.25;
  });
});

const whippedCreamSelection = document.getElementById("whipped-cream");

whippedCreamSelection.addEventListener("change", () => {
  const value = whippedCreamSelection.value;

  customizeInfo["whipped-cream"] = `${value}-img`;

  const selectedOption = whippedCreamSelection.querySelector("option:checked");

  whippedCreamPrice = parseFloat(selectedOption.dataset.price);

  updateDrinkPrice();

  whippedCreamImages.forEach((image) => {
    if (image.id === customizeInfo["whipped-cream"]) {
      image.style.opacity = 1;
    } else {
      image.style.opacity = 0;
    }
  });
});

const toppingsBtn = document.querySelectorAll(".toppings-container .toppings");

toppingsBtn.forEach((topping) => {
  topping.addEventListener("click", () => {
    customizeInfo["toppings"] = `${topping.value}-img`;

    toppingsPrice = parseFloat(topping.dataset.price);

    updateDrinkPrice();

    toppingsImages.forEach((image) => {
      if (image.id === customizeInfo["toppings"]) {
        image.style.opacity = 1;
      } else {
        image.style.opacity = 0;
      }
    });
  });
});

const flavorsBtn = document.querySelectorAll(".flavor-container .flavor");

flavorsBtn.forEach((flavor) => {
  flavor.addEventListener("click", () => {
    customizeInfo["flavor"] = `${flavor.value}-img`;

    flavorPrice = parseFloat(flavor.dataset.price);

    updateDrinkPrice();

    flavorImages.forEach((image) => {
      if (image.id === customizeInfo["flavor"]) {
        image.style.opacity = 0.8;
      } else {
        image.style.opacity = 0;
      }
    });
  });
});

const addonsList = document.querySelectorAll(".addons-container .addons");

addonsList.forEach((addons) => {
  addons.addEventListener("click", () => {
    if (addons.checked) {
      customizeInfo["addons"].push(`${addons.value}-img`);

      addonsPrice += parseFloat(addons.dataset.price);

      updateDrinkPrice();
    } else {
      const index = customizeInfo["addons"].indexOf(`${addons.value}-img`);
      if (index !== -1) {
        customizeInfo["addons"].splice(index, 1);
      }

      addonsPrice -= parseFloat(addons.dataset.price);

      updateDrinkPrice();
    }

    addonsImages.forEach((image) => {
      if (customizeInfo["addons"].includes(image.id)) {
        image.style.opacity = 0.6;
      } else {
        image.style.opacity = 0;
      }
    });
  });
});

const resetBtn = document.querySelector("form button[type=reset]");
const allImages = document.querySelectorAll(".customize-preview img");

resetBtn.addEventListener("click", () => {
  cupPrice = 0.0;
  flavorPrice = 0.0;
  addonsPrice = 0.0;
  whippedCreamPrice = 0.0;
  toppingsPrice = 0.0;

  updateDrinkPrice();

  allImages.forEach((image) => {
    image.style.opacity = 0;
  });
});

function updateDrinkPrice() {
  drinkTotalPrice =
    cupPrice + flavorPrice + whippedCreamPrice + toppingsPrice + addonsPrice;

  totalPrice.value = drinkTotalPrice.toFixed(2);
}
