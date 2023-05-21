document.addEventListener('DOMContentLoaded', () => {
    let addBtn = document.getElementById('btn-add')
    let deleteBtn = document.getElementById('btn-delete')
    let btnDiv = document.getElementById('btn-div')
    let count = document.getElementById('k-length').value;
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
        document.getElementById('k-length-new').value = count
    })

    deleteBtn.addEventListener('click', () => {
        if (count > 1){
            document.getElementById('kdiv-' + count).remove()
            count--
            document.getElementById('k-length-new').value = count
        }
    })
})