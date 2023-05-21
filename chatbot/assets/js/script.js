let i = 0;

document.addEventListener('DOMContentLoaded', starter)
document.addEventListener('', reset)

function starter() {
    let input = document.getElementById( 'message' );
    const scroller = document.getElementById( 'message-box' );

    input.addEventListener( 'keydown', function(e) {
        if( e.code === "Enter" || e.code === "NumpadEnter" )
        {
            if( input.value !== '' )
            {
                sendMessage();
            }
        }
    } )

// palette.addEventListener( 'change', function(){
//     selectColor();
// } )

    const bulle = document.getElementById('bulle')
    const button = document.getElementById('chat-button')
    const croix = document.getElementById('bulle-croix')

    croix.addEventListener('click', ()=>{
        bulle.classList.remove('bulle-animation')
        bulle.classList.add('bulle-animation-reverse')
        setTimeout(()=>{
            bulle.classList.add('hide-bulle')
        }, 500)
    })

    button.addEventListener('mouseover', ()=>{
        bulle.classList.remove('hide-bulle')
        bulle.classList.add('bulle-animation')
    })
}


function openChat(message)
{
    let chat = document.getElementById( 'chatbox' );
    let button = document.getElementById( 'chat-button' );
    let box = document.getElementById( 'message-box' );
    let element = document.createElement( 'div' );
    if (message === ''){
        message = "Bonjour, je suis Billy votre assistant automatique. Que puis-je faire pour vous ?"
    }

    bulle.classList.remove('bulle-animation')
    bulle.classList.add('hide-bulle')
    chat.classList.remove( 'close-chatbox' );
    chat.classList.add( 'open-chatbox' );
    button.classList.remove('button-animation-hover')
    button.classList.remove('button-animation')
    button.classList.remove( 'open-button' );
    button.classList.add( 'hide-button' )
    // insertAdjacentHTML( "beforeend", "<img src='./assets/img/bot-logo.png' height='25' width='auto' class='picture-ai'><div class='message-ai'>" + message +"</div>" );
    if( i === 0 )
    {
        let date = new Date;
        date = date.toLocaleString()
        box.insertAdjacentHTML('beforeend', `<p id="date">${date}</p>`)
        element.classList.add( 'ai-box' );
        element.insertAdjacentHTML( "beforeend", '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48.22 48" class="picture-ai"><defs><style>.cls-1{fill:#fff;}.cls-2{fill:#7b39eb;}.cls-2,.cls-3,.cls-4{stroke:#fff;stroke-miterlimit:10;}.cls-3{fill:none;}.cls-4{fill:#ffbf85;stroke-width:2px;}</style></defs><g id="fond_icone"><path class="cls-2" d="M33.65,3.72H14.88C7.11,3.72,.81,10.02,.81,17.8v4.21c0,4.82,2.43,9.08,6.13,11.61v7.38l7.73-4.93c.07,0,.15,.01,.22,.01h18.77c7.77,0,14.07-6.3,14.07-14.07v-4.21c0-7.77-6.3-14.07-14.07-14.07Z"/><ellipse class="cls-2" cx="24" cy="42.47" rx="4.19" ry="1.91"/></g><g id="Calque_2"><rect class="cls-3" x="4.88" y="12.15" width="38.17" height="16.98" rx="8.49" ry="8.49"/><g><g><circle class="cls-4" cx="12.76" cy="19.36" r="3.32"/><circle class="cls-4" cx="35.17" cy="19.36" r="3.32"/></g><path class="cls-1" d="M19.02,24.34c3.62,1.81,6.48,2.04,9.89,0-1.93,4.07-7.81,3.77-9.89,0h0Z"/></g></g></svg><div class="message-ai">' + message +"</div>" );
        box.appendChild(element)
        i++;
    }
}

function closeChat()
{
    let chat = document.getElementById( 'chatbox' );
    let button = document.getElementById( 'chat-button' );

    chat.classList.add( 'close-chatbox' );
    chat.classList.remove( 'hide-chatbox', 'open-chatbox' );
    button.classList.remove( 'hide-button' );
    button.classList.add('button-animation', 'open-button')
}

function reset(){
    document.getElementById('message-box').innerHTML = ''
    i = 0
    fetch('chatbot/chatapi.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            method: 'resetChat'
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                openChat(JSON.parse(data.result))
            } else {
                console.error(data.error);
            }
        })
        .catch(error => console.log(error));
}

function sendMessage()
{
    let message = document.getElementById( 'message' );
    let box = document.getElementById( 'message-box' );
    let element = document.createElement( 'div' );
    let request = escapeHtml( message.value);

    if( request !== '' )
    {
        element.classList.add( 'user-box' );
        element.insertAdjacentHTML( "beforeend", "<div class='message-user'>" + message.value +"</div><img src='chatbot/assets/img/user.png' class='picture-user'>" );
        box.appendChild( element );
        message.value = "";

        aiInterpretation( request );
        box.scrollTop += 9999
    }
}

function aiInterpretation( request ) {
    return  fetch('chatbot/chatApi.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            message: request.normalize("NFD").replace(/[\u0300-\u036f]/g, ""),
            method: 'findMessage'
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                return iaResponse( JSON.parse(data.result));
            } else {
                console.error(data.error);
            }
        })
        .catch(error => console.log(error));
}

function iaResponse( message )
{
    // message = message.slice(1, message.length - 1)
    let box = document.getElementById( 'message-box' );
    let element = document.createElement( 'div' );

    element.classList.add( 'ai-box' );
    document.getElementById('message').setAttribute('readonly', 'readonly')
    element.insertAdjacentHTML( "beforeend", '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48.22 48" class="picture-ai"><defs><style>.cls-1{fill:#fff;}.cls-2{fill:#7b39eb;}.cls-2,.cls-3,.cls-4{stroke:#fff;stroke-miterlimit:10;}.cls-3{fill:none;}.cls-4{fill:#ffbf85;stroke-width:2px;}</style></defs><g id="fond_icone"><path class="cls-2" d="M33.65,3.72H14.88C7.11,3.72,.81,10.02,.81,17.8v4.21c0,4.82,2.43,9.08,6.13,11.61v7.38l7.73-4.93c.07,0,.15,.01,.22,.01h18.77c7.77,0,14.07-6.3,14.07-14.07v-4.21c0-7.77-6.3-14.07-14.07-14.07Z"/><ellipse class="cls-2" cx="24" cy="42.47" rx="4.19" ry="1.91"/></g><g id="Calque_2"><rect class="cls-3" x="4.88" y="12.15" width="38.17" height="16.98" rx="8.49" ry="8.49"/><g><g><circle class="cls-4" cx="12.76" cy="19.36" r="3.32"/><circle class="cls-4" cx="35.17" cy="19.36" r="3.32"/></g><path class="cls-1" d="M19.02,24.34c3.62,1.81,6.48,2.04,9.89,0-1.93,4.07-7.81,3.77-9.89,0h0Z"/></g></g></svg><div class="message-ai"><img src="/chatbot/assets/img/loading.png" class="loading"></div>' );
    box.appendChild( element );
    box.scrollTop += 9999
    setTimeout(()=>{
        element.innerHTML = ''
        element.insertAdjacentHTML( "beforeend", '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48.22 48" class="picture-ai"><defs><style>.cls-1{fill:#fff;}.cls-2{fill:#7b39eb;}.cls-2,.cls-3,.cls-4{stroke:#fff;stroke-miterlimit:10;}.cls-3{fill:none;}.cls-4{fill:#ffbf85;stroke-width:2px;}</style></defs><g id="fond_icone"><path class="cls-2" d="M33.65,3.72H14.88C7.11,3.72,.81,10.02,.81,17.8v4.21c0,4.82,2.43,9.08,6.13,11.61v7.38l7.73-4.93c.07,0,.15,.01,.22,.01h18.77c7.77,0,14.07-6.3,14.07-14.07v-4.21c0-7.77-6.3-14.07-14.07-14.07Z"/><ellipse class="cls-2" cx="24" cy="42.47" rx="4.19" ry="1.91"/></g><g id="Calque_2"><rect class="cls-3" x="4.88" y="12.15" width="38.17" height="16.98" rx="8.49" ry="8.49"/><g><g><circle class="cls-4" cx="12.76" cy="19.36" r="3.32"/><circle class="cls-4" cx="35.17" cy="19.36" r="3.32"/></g><path class="cls-1" d="M19.02,24.34c3.62,1.81,6.48,2.04,9.89,0-1.93,4.07-7.81,3.77-9.89,0h0Z"/></g></g></svg><div class="message-ai">' + message +"</div>" );
        box.appendChild( element );
        document.getElementById('message').removeAttribute('readonly')
        box.scrollTop += 9999
    }, 2500)
}

// function selectColor()
// {
//     let palette = document.getElementById( 'palette' )
//     let r = document.querySelector( ':root' )
//     let rs = getComputedStyle( r )
//
//     switch( palette.value ){
//         case ( 'violet' ):
//             r.style.setProperty('--light-color', '#f0f2f5')
//             r.style.setProperty('--main-color', '#857dff')
//             r.style.setProperty('--main-dark-color', '#7B39EB')
//             r.style.setProperty('--gray-color', '#e4e6eb')
//             break
//         case ( 'vert' ):
//             r.style.setProperty('--light-color', '#f1f5f0')
//             r.style.setProperty('--main-color', '#7fff7d')
//             r.style.setProperty('--main-dark-color', '#12b50d')
//             r.style.setProperty('--gray-color', '#e6ebe4')
//             break
//         case ( 'bleu' ):
//             r.style.setProperty('--light-color', '#f1f5f0')
//             r.style.setProperty('--main-color', '#4538ff')
//             r.style.setProperty('--main-dark-color', '#397aeb')
//             r.style.setProperty('--gray-color', '#e6ebe4')
//             break
//     }
// }

function escapeHtml( text ) {
    var map = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    };
    
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}