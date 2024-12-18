<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diads - Secure Inbox</title>
    <link rel="stylesheet" href="css/inbox_styles.css">
</head>
<body>
    <div class="container">
        <div class="inbox-header">
            <h1>Secure Inbox</h1>
            <button id="compose-btn" onclick="openComposeModal()">Compose</button>
            <div class="inbox-tabs">
                <div class="inbox-tab active" onclick="switchTab('messages')">Messages</div>
                <div class="inbox-tab" onclick="switchTab('mail')">Mail</div>
            </div>
        </div>
        <div id="inbox-content"></div>
    </div>

    <div id="compose-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeComposeModal()">&times;</span>
            <h2>Compose Message</h2>
            <input type="text" id="recipient" placeholder="Recipient">
            <input type="text" id="subject" placeholder="Subject">
            <textarea id="message-body" placeholder="Write your message here"></textarea>
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>

    <script src="js/encryption.js"></script>
    <script src="js/inbox.js"></script>
</body>
</html>
