window.addEventListener("scroll", checkboxes)

function checkboxes() {
  const boxes = document.querySelectorAll(".box")
  const triggerBottom = window.innerHeight / 5 * 4;
  boxes.forEach(box => {
    const boxTop = box.getBoundingClientRect().top

    if (boxTop< triggerBottom) {
      box.classList.add("show")
    } else {
      box.classList.remove("show")
    }
  })
}

window.addEventListener("scroll", checkboxes1)

function checkboxes1() {
  const boxes = document.querySelectorAll(".box1")
  const triggerBottom = window.innerHeight / 4 * 3;
  boxes.forEach(box => {
    const boxTop = box.getBoundingClientRect().top

    if (boxTop< triggerBottom) {
      box.classList.add("show")
    } else {
      box.classList.remove("show")
    }
  })
}

// const activeState = (e)=>{
//   const id = e.target.id
//   const idArray = ["1","2","3","4","5"]

//   idArray.forEach((element)=> {
//       document.getElementById(element).classList.remove("active")
//   });
//   document.getElementById(id).classList.add("active")
// }

// function activeAccueil() {
//   const buttons = document.querySelectorAll("nav")
//   const id = 1;
//   const idArray = ["0","1","2","3"]

//   buttons.forEach((button) => {
//     button.addEventListener("click", function() {
//       idArray.forEach((element) => {
//         document.getElementById(element).classList.remove("active");
//       });
//       document.getElementById(id).classList.add("active");
//     });
//   });

//   idArray.forEach((element)=> {
//       document.getElementById(element).classList.remove("active")
//   });
//   document.getElementById(id).classList.add("active");
// }

// const buttons = document.querySelectorAll("nav");
// const idArray = ["1", "2", "3", "4", "5"];

// buttons.forEach((button) => {
//   button.addEventListener("click", function() {
//     idArray.forEach((element) => {
//       document.getElementById(element).classList.remove("active");
//     });
//     this.classList.add("active");
//   });
// });
function toggleActiveClass() {
  const navLinks = document.querySelectorAll('.navbar-nav a');
  navLinks.forEach(link => {
    link.addEventListener('click', function () {
      navLinks.forEach(link => link.classList.remove('active'));
      this.classList.add('active');
    });
  });
}

document.addEventListener('DOMContentLoaded', toggleActiveClass);

window.onscroll = function() {
  scrollFunction()
};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20 ) {
    document.getElementById("topBtn").style.display = "block";
  } else {
    document.getElementById("topBtn").style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

document.getElementById("topBtn").addEventListener("click", topFunction);