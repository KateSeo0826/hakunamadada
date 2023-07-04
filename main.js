
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

//tags color change after clicking

let prevButton = null;
let tagsButtons = document.querySelectorAll('.tags-btn')
console.log(tagsButtons)
// tagsBox.addEventListener('click', (e) => {
//     const isButton = e.target.nodeName === 'BUTTON'
//     if (!isButton) {
//         return
//     }
//     e.target.classList.add('active')

//     if (prevButton !== null) {
//         prevButton.classList.remove('active')
//     }
//     prevButton = e.target;
// })

for (let i = 0; i < tagsButtons.length; i++) {
    tagsButtons[i].addEventListener('click', (e) => {
        let prevBtn = document.querySelector('.checked')
        if (prevBtn) {
            e.target.classList.add('checked')
        }
        else {
            e.target.classList.add('checked')
        }
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