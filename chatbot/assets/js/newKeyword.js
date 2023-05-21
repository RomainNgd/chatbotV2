document.addEventListener('DOMContentLoaded', () => {
    let addBtn = document.getElementById('btn-add')
    let deleteBtn = document.getElementById('btn-delete')
    let btnDiv = document.getElementById('btn-div')
    let count = 1;
    addBtn.addEventListener('click', () => {
        count++
        btnDiv.insertAdjacentHTML('beforebegin',
            '<div class="keyword-div" id="kdiv-'+ count +'">\n' +
            '<label class="keyword-label" for="keyword-'+ count +'">Mot clée '+ count +' :</label>\n' +
            '<input type="text" id="keyword-'+ count +'" required name="keyword-'+ count +'" placeholder="mot-clée">\n' +
            '<label class="keyword-label" for="priority-'+ count +'">Priorité :</label>\n' +
            '<input type="number" id="priority-'+ count +'" required name="priority-'+ count +'" placeholder="2">'+
            '</div>'
            )
    })

    deleteBtn.addEventListener('click', () => {
        if (count > 1){
            document.getElementById('kdiv-' + count).remove()
            count--
        }
    })

    let suppbtn = document.getElementsByName('delete');
    suppbtn.forEach((element) => {
        element.addEventListener('click', () => {
            let responseId = element.value
            let url = document.getElementById('deleteUrl').getAttribute('href')
            document.getElementById('deleteUrl').setAttribute('href', url + responseId)
        })
    })
})