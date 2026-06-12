//WEWE ACCORDION
var elements = document.querySelectorAll("[data-toggle='accordion']");
var waccordion = document.querySelectorAll(".w-accordion-slide");
for (var i = 0; i < elements.length; i++) {
  elements[i].addEventListener("click", function () {
    let target = this.dataset.target;
    let target_el = document.getElementById(target);
    console.log(target_el);
    for (var i = 0; i < waccordion.length; i++) {
      waccordion[i].classList.remove("active");
    }
    target_el.classList.add("active");
  });
}