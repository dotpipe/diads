const ENCRYPTION_KEY = 'your-secret-key-here'; // Replace with a secure, randomly generated key

function encryptMessage(message) {
    if (!ENCRYPTION_KEY) {
        throw new Error("Encryption key not set");
    }
    const iv = crypto.getRandomValues(new Uint8Array(16));
    const key = crypto.subtle.importKey(
        'raw',
        new TextEncoder().encode(ENCRYPTION_KEY),
        { name: 'AES-CBC' },
        false,
        ['encrypt']
    );
    
    return key.then(key => crypto.subtle.encrypt(
        { name: 'AES-CBC', iv: iv },
        key,
        new TextEncoder().encode(message)
    )).then(encrypted => {
        const encryptedContent = new Uint8Array(encrypted);
        const result = new Uint8Array(iv.length + encryptedContent.length);
        result.set(iv);
        result.set(encryptedContent, iv.length);
        return btoa(String.fromCharCode.apply(null, result));
    });
}

function decryptMessage(encryptedMessage) {
    if (!ENCRYPTION_KEY) {
        throw new Error("Encryption key not set");
    }
    const encryptedData = new Uint8Array(atob(encryptedMessage).split('').map(char => char.charCodeAt(0)));
    const iv = encryptedData.slice(0, 16);
    const data = encryptedData.slice(16);
    
    const key = crypto.subtle.importKey(
        'raw',
        new TextEncoder().encode(ENCRYPTION_KEY),
        { name: 'AES-CBC' },
        false,
        ['decrypt']
    );
    
    return key.then(key => crypto.subtle.decrypt(
        { name: 'AES-CBC', iv: iv },
        key,
        data
    )).then(decrypted => new TextDecoder().decode(decrypted));
}

function updateItemList(data) {
    const itemList = document.getElementById('item-list');
    if (itemList) {
        itemList.innerHTML = '';
        data.forEach(item => {
            itemList.innerHTML += `
                <div class="item">
                    <h3>${item.name}</h3>
                    <p>Price: ${item.price}</p>
                    <p>Quantity: ${item.quantity}</p>
                    <button onclick="addToCart(${item.id})">Add to Cart</button>
                </div>
            `;
        });
    }
}

function handleNewOrder(order) {
    const ordersContainer = document.getElementById('orders-container');
    if (ordersContainer) {
        ordersContainer.innerHTML += `
            <div class="order">
                <h3>New Order #${order.id}</h3>
                <p>Total: ${order.total}</p>
                <p>Status: ${order.status}</p>
                <button onclick="processOrder(${order.id})">Process Order</button>
            </div>
        `;
    }
    // Notify user of new order
    showNotification('New Order', `Order #${order.id} has been received.`);
}

function displayChatMessage(message) {
    const chatContainer = document.getElementById('chat-container');
    if (chatContainer) {
        const decryptedMessage = decryptMessage(message.content);
        chatContainer.innerHTML += `
            <div class="chat-message">
                <strong>${message.sender}:</strong> ${decryptedMessage}
            </div>
        `;
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
}

function sendChatMessage() {
    const messageInput = document.getElementById('chat-input');
    const message = messageInput.value;
    if (message) {
        const encryptedMessage = encryptMessage(message);
        socket.send(JSON.stringify({
            type: 'chat',
            content: encryptedMessage
        }));
        messageInput.value = '';
        saveChatMessage(encryptedMessage);
    }
}

function saveChatMessage(encryptedMessage) {
    fetch('/api/save_chat.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            token: apiKey,
            message: encryptedMessage
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status !== 'success') {
            console.error('Failed to save chat message');
        }
    });
}
