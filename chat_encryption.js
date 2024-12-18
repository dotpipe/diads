// Add token handling to chat functions
async function sendChatMessage() {
    const messageInput = document.getElementById('chat-input');
    const message = messageInput.value;
    if (message) {
        const encryptedMessage = await encryptMessage(message);
        fetch('/api/save_chat.php', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${apiToken}`,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                message: encryptedMessage
            })
        })
        .then(response => {
            if (response.status === 401) {
                window.location.href = '/login.php';
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                messageInput.value = '';
            }
        });
    }
}