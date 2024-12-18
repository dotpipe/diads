const socket = new WebSocket('ws://localhost:8080');
const encryption = new ClientEncryption();

socket.onopen = function(e) {
    console.log("WebSocket connection established");
};

socket.onmessage = async function(event) {
    const data = JSON.parse(event.data);
    if (data.type === 'key') {
        encryption.setPublicKey(data.key);
    } else if (data.type === 'message') {
        const decryptedMessage = await encryption.decrypt(data.content);
        displayMessage(decryptedMessage);
    }
};

async function sendMessage(message) {
    const encryptedMessage = await encryption.encrypt(message);
    socket.send(JSON.stringify({type: 'message', content: encryptedMessage}));
}

function displayMessage(message) {
    const chatPane = document.getElementById('chatpane');
    if (chatPane) {
        const messageElement = document.createElement('div');
        messageElement.textContent = message;
        messageElement.className = 'chat-message';
        chatPane.appendChild(messageElement);
        chatPane.scrollTop = chatPane.scrollHeight;
    }
}

