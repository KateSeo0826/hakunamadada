//date
let d = new Date();
let c_year = d.getFullYear();
console.log(c_year)
let c_month = d.getMonth() + 1;

if (c_month < 10) {
    c_month = '0' + c_month;
}
let c_date = d.getDate();
if (c_date < 10) {
    c_date = '0' + c_date;
}

let c_day = c_year + "-" + c_month + "-" + c_date;

document.getElementById("date").value = c_day;

/* Toggle Button*/
const navbarMenu = document.querySelector('.header-menu')
const toggleBtn = document.querySelector('.navbar-toggleBtn')

toggleBtn.addEventListener('click', () => {
    navbarMenu.classList.toggle('open')
})

//Navbar menu click 
navbarMenu.addEventListener('click', () => {
    navbarMenu.classList.remove('open')
})
// slide
const slider = document.getElementsByClassName('slider')

for (const s of slider) {
    let isMouseDown = false
    let initialPageX, scrollLeft

    const detectMovement = movement => {
        isMouseDown = movement
        //movement ? s.classList.add('active') : s.classList.remove('active')
    }

    s.addEventListener('mousedown', e => {
        detectMovement(true)
        isMouseDown = true
        initialPageX = e.pageX
        scrollLeft = s.scrollLeft
    })

    s.addEventListener('mouseup', () => detectMovement(false))
    s.addEventListener('mouseleave', () => detectMovement(false))

    s.addEventListener('mousemove', e => {
        if (!isMouseDown) return
        e.preventDefault()
        s.scrollLeft = scrollLeft - (e.pageX - initialPageX)
    })
}





//Modal
const modal = document.querySelector('.modal')
const overlay = document.querySelector(".overlay")
const openModalBtn = document.querySelector(".btn-open")
const closeModalBtn = document.querySelector(".btn-close")

const openModal = () => {
    modal.classList.remove('hidden')
    overlay.classList.remove('hidden')
}

openModalBtn.addEventListener('click', openModal)

const closeModal = () => {
    modal.classList.add('hidden')
    overlay.classList.add('hidden')
}

closeModalBtn.addEventListener('click', closeModal)

overlay.addEventListener("click", closeModal);

document.addEventListener('keydown')

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
        modalClose()
    }
})


