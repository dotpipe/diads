async function loadInboxContent(type = 'messages') {
    const response = await fetch(`api/get_${type}.php`);
    const messages = await response.json();

    const contentDiv = document.getElementById('inbox-content');
    contentDiv.innerHTML = messages.map(msg => `
        <div class="inbox-item">
            <span class="encrypted-icon">🔒</span>
            <h3>${msg.subject}</h3>
            <p>${msg.content}</p>
            <div class="read-status">
                <button onclick="toggleReadStatus(this)">Mark as Read</button>
            </div>
        </div>
    `).join('');
}

function toggleReadStatus(button) {
    if (button.textContent === "Mark as Read") {
        button.textContent = "Mark as Unread";
        button.parentElement.parentElement.style.opacity = "0.6";
    } else {
        button.textContent = "Mark as Read";
        button.parentElement.parentElement.style.opacity = "1";
    }
}

function switchTab(type) {
    document.querySelectorAll('.inbox-tab').forEach(tab => tab.classList.remove('active'));
    event.target.classList.add('active');
    loadInboxContent(type);
}

function openComposeModal() {
    document.getElementById('compose-modal').style.display = 'block';
}

function closeComposeModal() {
    document.getElementById('compose-modal').style.display = 'none';
}

async function sendMessage() {
    const recipient = document.getElementById('recipient').value;
    const subject = document.getElementById('subject').value;
    const body = document.getElementById('message-body').value;

    const encryptedMessage = await encryptMessage(body);

    const response = await fetch('api/send_message.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            recipient,
            subject,
            message: encryptedMessage.encrypted,
            iv: encryptedMessage.iv
        }),
    });

    if (response.ok) {
        closeComposeModal();
        loadInboxContent();
    } else {
        alert('Failed to send message');
    }
}

loadInboxContent();
