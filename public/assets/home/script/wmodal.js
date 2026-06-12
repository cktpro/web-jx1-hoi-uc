// v1.0.1

const myBody = document.getElementsByTagName("BODY")[0];
const allmodal = document.querySelectorAll(".wmodal");
const btnwmodal = document.querySelectorAll("[data-toggle='modal']");
for (let i = 0; i < btnwmodal.length; i++) {
  btnwmodal[i].addEventListener("click", function () {
    let target = this.dataset.target;
    const target_el = document.getElementById(target);
    target_el.classList.add("show");
    myBody.classList.add("overflow-hidden");
    target_el.addEventListener("click", function () {
      this.classList.remove("show");
      myBody.classList.remove("overflow-hidden");
    });
  });
}

//button close
const btnclose = document.querySelectorAll("[data-dismiss='modal']");
for (let i = 0; i < btnclose.length; i++) {
  btnclose[i].addEventListener("click", function () {
    let target_el = this.closest(".wmodal.show");
    target_el.classList.remove("show");
    myBody.classList.remove("overflow-hidden");
  });
}

var wmodaldialog = document.getElementsByClassName("wmodal-dialog");
var i;
for (i = 0; i < wmodaldialog.length; i++) {
  wmodaldialog[i].addEventListener("click", function () {
    event.stopPropagation();
  });
}

// modal youtube
const modalyoutube = document.getElementById("modal-youtube");
const blockyoutube = document.getElementById("w-youtube");
const btnyoutube = document.querySelectorAll("[data-toggle='youtube']");
for (let i = 0; i < btnyoutube.length; i++) {
  btnyoutube[i].addEventListener("click", function () {
    let target = this.dataset.target;
    blockyoutube.src = "";
    blockyoutube.src = target;
    // alert(target);
    modalyoutube.classList.add("show");
    myBody.classList.add("overflow-hidden");

    modalyoutube.addEventListener("click", function () {
      this.classList.remove("show");
      myBody.classList.remove("overflow-hidden");
    });
  });
}

//OFFCANVAS
const btnoffcanvas = document.querySelectorAll("[data-toggle='offcanvas']");
for (let i = 0; i < btnoffcanvas.length; i++) {
  btnoffcanvas[i].addEventListener("click", function () {
    let target = this.dataset.target;
    let target_el = document.getElementById(target);

    target_el.classList.add("show");
    myBody.classList.add("overflow-hidden");

    target_el.addEventListener("click", function () {
      this.classList.remove("show");
      myBody.classList.remove("overflow-hidden");
    });
  });
}
var offcanvascontent = document.getElementsByClassName("offcanvas-content");
var i;
for (i = 0; i < offcanvascontent.length; i++) {
  offcanvascontent[i].addEventListener("click", function () {
    event.stopPropagation();
  });
}

// float
const btnmini = document.querySelectorAll("[data-toggle='minimize']");
for (let i = 0; i < btnmini.length; i++) {
  btnmini[i].addEventListener("click", function () {
    let target = this.dataset.target;
    let target_el = this.closest(target);
    console.log(target_el);
    target_el.classList.toggle("minimize");
  });
}