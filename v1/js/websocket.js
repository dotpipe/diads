const socket = new WebSocket('ws://localhost:8080');

socket.onopen = function(e) {
    console.log("WebSocket connection established");
};

socket.onmessage = function(event) {
    const message = JSON.parse(event.data);
    updateInbox(message);
};

socket.onclose = function(event) {
    if (event.wasClean) {
        console.log('WebSocket connection closed cleanly');
    } else {
        console.log('WebSocket connection died');
        pingServer();
    }
};

socket.onerror = function(error) {
    console.log('WebSocket error: ' + error.message);
};

function pingServer() {
    // Implement server ping logic
}

function updateInbox(message) {
    // Update inbox with new message
}
