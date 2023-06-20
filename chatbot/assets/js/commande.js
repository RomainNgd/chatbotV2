window.addEventListener('DOMContentLoaded', () => {
    let pens = document.getElementsByClassName('edit-status')
    for (pen of pens){
        setUp(pen)
    }
})

function setUp(element){
    element.addEventListener('click', () => {
        console.log('test')
        element.getElementById('edit-status').classList.toggle('hidden')
    })
}