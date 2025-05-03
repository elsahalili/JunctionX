<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Clone</title>
    <link rel="stylesheet" >
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap');

body {
    margin: 0;
    padding: 0;
    font-family: 'Orbitron', sans-serif;
    background: linear-gradient(135deg, #0f0f0f, #1a1a2e);
    color: #fff;
    overflow: hidden;
}

.chat-container {
    display: flex;
    height: 100vh;
    backdrop-filter: blur(4px);
}

/* Sidebar */
.sidebar {
    width: 250px;
    background: linear-gradient(180deg, #1a1a2e, #16213e);
    border-right: 2px solid #00f0ff;
    box-shadow: 0 0 15px #00f0ff;
    padding: 20px;
    overflow-y: auto;
}

.profile {
    display: flex;
    align-items: center;
    margin-bottom: 30px;
}

.profile img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid #00f0ff;
    margin-right: 10px;
}

.username {
    font-weight: bold;
    color: #00f0ff;
    text-shadow: 0 0 5px #00f0ff;
}

.contact-list {
    list-style: none;
    padding: 0;
}

.contact-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    cursor: pointer;
    transition: transform 0.3s;
}

.contact-item:hover {
    transform: scale(1.05);
}

.contact-image {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
    border: 2px solid #00f0ff;
}

/* Chat Window */
.chat-window {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: url('https://media.giphy.com/media/3o7aCSDsne6jV2A6lC/giphy.gif') center/cover no-repeat;
    backdrop-filter: blur(5px);
    position: relative;
    z-index: 1;
}

.chat-header {
    background-color: rgba(18, 140, 126, 0.9);
    padding: 15px;
    display: flex;
    align-items: center;
    font-size: 18px;
    font-weight: bold;
    border-bottom: 2px solid #00f0ff;
    box-shadow: 0 0 10px #00f0ff;
}

.chat-body {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.message {
    max-width: 70%;
    padding: 10px 15px;
    border-radius: 10px;
    font-size: 14px;
    word-wrap: break-word;
    box-shadow: 0 0 10px rgba(0,0,0,0.5);
    animation: floatIn 0.5s ease;
}

@keyframes floatIn {
    from {
        transform: translateY(10px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.sent {
    background-color: #00f0ff;
    color: #000;
    align-self: flex-end;
    border: 1px solid #fff;
}

.received {
    background-color: #1f4068;
    color: #fff;
    align-self: flex-start;
    border: 1px solid #00f0ff;
}

/* Chat Input */
.chat-input {
    display: flex;
    padding: 15px;
    background: rgba(0, 0, 0, 0.6);
    border-top: 2px solid #00f0ff;
}

.chat-input input {
    flex: 1;
    padding: 12px;
    border: 1px solid #00f0ff;
    background: #0f0f0f;
    color: #00f0ff;
    border-radius: 5px;
    font-size: 14px;
    margin-right: 10px;
    outline: none;
}

.chat-input button {
    padding: 12px 20px;
    background-color: #00f0ff;
    color: black;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s ease;
}

.chat-input button:hover {
    background-color: #0ff;
    transform: scale(1.1);
}

    </style>
</head>
<body>
    <div class="chat-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="profile">
                <img src="blerton.jpg" alt="Profile Picture">
                <span class="username">Blerton Hamzai</span>
            </div>
            <ul class="contact-list">
                <li class="contact-item">
                    <img src="https://www.shutterstock.com/image-photo/enjoy-nature-beauty-young-man-260nw-1652056141.jpg" alt="Profile Picture" class="contact-image">
                    <a href="ethan.php" style="text-decoration: none; color: aliceblue;">Ethan</a>
                </li>
                
            </ul>
            </ul>
            
     </div>

        <!-- Chat Window -->
        <div class="chat-window">
            <div class="chat-header">
                <span class="contact-name">
                    <img src="https://www.shutterstock.com/image-photo/enjoy-nature-beauty-young-man-260nw-1652056141.jpg" height="60px"  width="60px" style="border-radius: 50%;">
                    Ethan
                </span>
            </div>
            
            <div class="chat-body" id="chat-body">
                <!-- Messages will appear here -->
            </div>
            <div class="chat-input">
                <input type="text" id="message-input" placeholder="Type a message">
                <button id="send-btn">Send</button>
            </div>
        </div>
    </div>
    <script>
document.getElementById("send-btn").addEventListener("click", sendMessage);
document.getElementById("message-input").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        sendMessage();
    }
});

function sendMessage() {
    const messageInput = document.getElementById("message-input");
    const messageText = messageInput.value.trim();

    if (messageText === "") return; // Don't send empty messages

    // Create the message element
    const messageElement = document.createElement("div");
    messageElement.classList.add("message", "sent");
    messageElement.textContent = messageText;

    // Append the message to the chat body
    const chatBody = document.getElementById("chat-body");
    chatBody.appendChild(messageElement);

    // Clear the input field
    messageInput.value = "";
    chatBody.scrollTop = chatBody.scrollHeight; // Scroll to bottom
}

// You can also add received messages for the "Alice" chat as an example
function receiveMessage(text) {
    const messageElement = document.createElement("div");
    messageElement.classList.add("message", "received");
    messageElement.textContent = text;

    const chatBody = document.getElementById("chat-body");
    chatBody.appendChild(messageElement);
    chatBody.scrollTop = chatBody.scrollHeight; // Scroll to bottom
}

// Example of receiving a message after 2 seconds
setTimeout(() => {
    receiveMessage("Ethan: Hi Bro");
}, 2000);
setTimeout(() => {
    receiveMessage("Ethan: How are u bro!");
}, 10000);
setTimeout(() => {
    receiveMessage("Ethan: Do you wanna come with me to watch a movie in cinema, let me know");
}, 20000);
setTimeout(() => {
    receiveMessage("Ethan: perfect tommorow at 6pm");
}, 32000);

</script>


</body>
</html>


