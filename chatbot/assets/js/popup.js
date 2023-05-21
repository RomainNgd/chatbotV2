document.addEventListener('DOMContentLoaded', ()=>{
    document.getElementsByName('btn-delete').forEach((element) => editPopup(element))
})

function editPopup(element){
    element.addEventListener('click', () => {
        let btn = document.getElementById('delete')
        let item = element.getAttribute('data-entity-name')
        console.log(item)
        document.getElementById('item').value = element.value
        let url = btn.getAttribute('href')
        let id = element.value
        let newUrl = url + id
        btn.setAttribute('href', newUrl)
        document.getElementById('item').innerText = item
    })
}