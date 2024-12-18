const socket = new WebSocket('ws://localhost:8080');
const apiToken = localStorage.getItem('apiToken');

socket.onopen = function(e) {
    // Authenticate WebSocket connection
    socket.send(JSON.stringify({
        type: 'auth',
        token: apiToken
    }));
};

socket.onmessage = function(event) {
    const message = JSON.parse(event.data);
    if (message.type === 'auth_error') {
        localStorage.removeItem('apiToken');
        window.location.href = '/login.php';
        return;
    }
    updateInbox(message);
};