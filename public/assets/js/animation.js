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

const activeState = (e)=>{
  const id = e.target.id
  const idArray = ["1","2","3","4","5"]

  idArray.forEach((element)=> {
      document.getElementById(element).classList.remove("active")
  });
  document.getElementById(id).classList.add("active")
}

function activeAccueil() {
  const id = 1;
  const idArray = ["0","1","2","3"]

  idArray.forEach((element)=> {
      document.getElementById(element).classList.remove("active")
  });
  document.getElementById(id).classList.add("active");
}