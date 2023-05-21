<div id="bulle" class="hide-bulle">
    <div>
        <img src="<?= URL; ?>assets/img/croix.png" alt="" id="bulle-croix">
    </div>
    <div class="brand">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48.22 48" class="logo"><defs><style>.cls-1{fill:#fff;}.cls-2{fill:#7b39eb;}.cls-2,.cls-3,.cls-4{stroke:#fff;stroke-miterlimit:10;}.cls-3{fill:none;}.cls-4{fill:#ffbf85;stroke-width:2px;}</style></defs><g id="fond_icone"><path class="cls-2" d="M33.65,3.72H14.88C7.11,3.72,.81,10.02,.81,17.8v4.21c0,4.82,2.43,9.08,6.13,11.61v7.38l7.73-4.93c.07,0,.15,.01,.22,.01h18.77c7.77,0,14.07-6.3,14.07-14.07v-4.21c0-7.77-6.3-14.07-14.07-14.07Z"/><ellipse class="cls-2" cx="24" cy="42.47" rx="4.19" ry="1.91"/></g><g id="Calque_2"><rect class="cls-3" x="4.88" y="12.15" width="38.17" height="16.98" rx="8.49" ry="8.49"/><g><g><circle class="cls-4" cx="12.76" cy="19.36" r="3.32"/><circle class="cls-4" cx="35.17" cy="19.36" r="3.32"/></g><path class="cls-1" d="M19.02,24.34c3.62,1.81,6.48,2.04,9.89,0-1.93,4.07-7.81,3.77-9.89,0h0Z"/></g></g></svg>
        <h2 class="name">BILLY</h2>
    </div>
    Bonjour, je suis billy, un robot à votre service. <br> Posez moi une question !
</div>
<div class="button-animation" id="chat-button" onclick="openChat('')">
    <svg id="button-svg" class="openlogo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 272 187.03"><defs><style>.cls-1{fill:#8a2bff;}.cls-1,.cls-2{stroke:#fff;stroke-miterlimit:10;}.cls-2{fill:#fff;}</style></defs><g id="Calque_1-2"><g><path class="cls-1" d="m229.72,115.5H100.06l-44.56,35,13.78-35c-22.98,0-41.78-18.8-41.78-41.78v-31.44C27.5,19.3,46.3.5,69.28.5h160.44c22.98,0,41.78,18.8,41.78,41.78v31.44c0,22.98-18.8,41.78-41.78,41.78Z"/><path class="cls-2" d="m202.72,150.5H73.06l-44.56,35,13.78-35c-22.98,0-41.78-18.8-41.78-41.78v-31.44c0-22.98,18.8-41.78,41.78-41.78h160.44c22.98,0,41.78,18.8,41.78,41.78v31.44c0,22.98-18.8,41.78-41.78,41.78Z"/></g></g></svg>
</div>
<div id="chatbox" class="close-chatbox">
    <div id="chatbox-header">
        <div class="brand">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48.22 48" class="logo"><defs><style>.cls-1{fill:#fff;}.cls-2{fill:#7b39eb;}.cls-2,.cls-3,.cls-4{stroke:#fff;stroke-miterlimit:10;}.cls-3{fill:none;}.cls-4{fill:#ffbf85;stroke-width:2px;}</style></defs><g id="fond_icone"><path class="cls-2" d="M33.65,3.72H14.88C7.11,3.72,.81,10.02,.81,17.8v4.21c0,4.82,2.43,9.08,6.13,11.61v7.38l7.73-4.93c.07,0,.15,.01,.22,.01h18.77c7.77,0,14.07-6.3,14.07-14.07v-4.21c0-7.77-6.3-14.07-14.07-14.07Z"/><ellipse class="cls-2" cx="24" cy="42.47" rx="4.19" ry="1.91"/></g><g id="Calque_2"><rect class="cls-3" x="4.88" y="12.15" width="38.17" height="16.98" rx="8.49" ry="8.49"/><g><g><circle class="cls-4" cx="12.76" cy="19.36" r="3.32"/><circle class="cls-4" cx="35.17" cy="19.36" r="3.32"/></g><path class="cls-1" d="M19.02,24.34c3.62,1.81,6.48,2.04,9.89,0-1.93,4.07-7.81,3.77-9.89,0h0Z"/></g></g></svg>
            <h2 class="name">BILLY</h2>
        </div>
        <div class="brand">
            <img id="reset" class="logo" src="<?= URL; ?>assets/img/reload.png" alt="" onclick="reset()">
            <img id="hide" class="logo" src="<?= URL; ?>assets/img/croix.png" alt="" onclick="closeChat()">
        </div>
    </div>
    <div id="body-chatbox">
        <div id="message-box">
        </div>
    </div>
    <div id="footer-chatbox">
        <input type="text" id="message" placeholder="Votre message">
        <img onclick="sendMessage()" id="envoyer" src="<?= URL; ?>assets/img/send-message.png" alt="send button">
        <!-- <img onclick="spreechToText()" id="micro" src="./assets/img/icons8-microphone-48.png" alt="microphone" width="10%"> -->
    </div>
</div>

<!-- Sélection d'une palette de couleur pour le chat -->
<select name="color" id="palette">
    <option value="violet" selected>VIOLET</option>
    <option value="orange">ORANGE</option>
    <option value="vert">VERT</option>
    <option value="bleu">BLEU</option>
</select>