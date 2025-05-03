<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Clone</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    height: 100vh;
    background-color: #f1f1f1;
}

.chat-header {
    display: flex;
    align-items: center;
    padding: 20px;
    cursor: pointer;
    border-bottom: 1px solid #ddd;
    margin-bottom: 10px;
}

.contact-name {
    font-size: 18px; /* Larger font size for the contact name */
    font-weight: bold; /* Makes the name bold */
    margin-left: 10px; /* Adds some space between the image and the name */
    color: #333; /* Dark color for the text */
}
/* alice phoyo */

/* Style for the contact item */
.contact-item {
    display: flex;
    align-items: center;
    padding: 20px;
    cursor: pointer;
    border-bottom: 1px solid #ddd;
    margin-bottom: 10px;
}

.contact-item:hover {
    background-color: #f1f1f1;
}

/* Style for the profile image */
.contact-image {
    width: 60px; /* Set the image width to 40px */
    height: 55px; /* Set the image height to 40px to make it a square */
    border-radius: 50%; /* Make the image round */
    margin-right: 10px; /* Add some space between the image and the text */
}

/* Sidebar Styles */
.chat-container {
    display: flex;
    width: 100%;
}

.sidebar {
    width: 250px;
    background-color: #075e54;
    color: white;
    display: flex;
    flex-direction: column;
    padding: 10px;
    box-sizing: border-box;
}

.profile {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.profile img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
}

.username {
    font-weight: bold;
    font-size: 16px;
}

.contact-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.contact-item {
    padding: 10px;
    cursor: pointer;
    border-bottom: 1px solid #ddd;
}

.contact-item:hover {
    background-color: #128C7E;
}

/* Chat Window Styles */
.chat-window {
    flex: 1;
    display: flex;
    flex-direction: column;
    background-color: white;
    padding: 20px;
    box-sizing: border-box;
}

.chat-header {
    background-color: #128C7E;
    color: white;
    padding: 15px;
    font-size: 18px;
    text-align: center;
}

.chat-body {
    flex: 1;
    overflow-y: auto;
    margin-top: 20px;
    padding-bottom: 20px;
}

.chat-input {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

#message-input {
    width: 85%;
    padding: 10px;
    border-radius: 20px;
    border: 1px solid #ddd;
    outline: none;
}

#message-input:focus {
    border-color: #128C7E;
}

#send-btn {
    width: 10%;
    padding: 10px;
    background-color: #128C7E;
    color: white;
    border: none;
    border-radius: 20px;
    cursor: pointer;
}

#send-btn:hover {
    background-color: #075e54;
}

/* Message Styles */
.message {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 10px;
    max-width: 60%;
}

.message.sent {
    background-color: #dcf8c6;
    align-self: flex-end;
}

.message.received {
    background-color: #ffffff;
    align-self: flex-start;
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
                <li class="contact-item">
                    <img src="https://as2.ftcdn.net/v2/jpg/02/37/00/65/1000_F_237006581_wgqyjkS1WyxLEpTuIrp1ZI7mnSD8kMQX.jpg" alt="Profile Picture" class="contact-image">
                    <a href="alice.php" style="text-decoration: none; color: aliceblue;">Alice</a>
                </li>
                <li class="contact-item">
                    <img src="https://www.shutterstock.com/image-photo/selfie-girl-paris-france-young-600nw-2167061949.jpg" alt="Profile Picture" class="contact-image">
                    <a href="ema.php"  style="text-decoration: none; color: aliceblue;" >Emma</a>
                </li>
            </ul>
            <ul class="contact-list">
                <li class="contact-item">
                    <img src="https://www.yourtango.com/sites/default/files/image_blog/things-strong-secure-stable-women-do-different.png" alt="Profile Picture" class="contact-image">
                    Ava
                </li>
                <li class="contact-item">
                    <img src="https://st.depositphotos.com/8509220/55284/i/1600/depositphotos_552844094-stock-photo-man-tourist-on-background-of.jpg" alt="Profile Picture" class="contact-image">
                    Noah
                </li>
                <li class="contact-item">
                    <img src="https://www.shutterstock.com/image-photo/traveler-woman-relaxing-on-swing-260nw-2130878285.jpg" class="contact-image">
                    Emily
                </li>
                <!-- Add more contacts as needed -->
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

let responseQueue = [
    "Ethan: Hello and Welcome, How can i help you",
    "Ethan: How are you, bro?",
    "Ethan: Wanna go watch a movie in the cinema?",
    "Ethan: Perfect, tomorrow at 6PM works!"
];
let responseIndex = 0;

function sendMessage() {
    const messageInput = document.getElementById("message-input");
    const messageText = messageInput.value.trim();

    if (messageText === "") return;

    const messageElement = document.createElement("div");
    messageElement.classList.add("message", "sent");
    messageElement.textContent = messageText;

    const chatBody = document.getElementById("chat-body");
    chatBody.appendChild(messageElement);

    messageInput.value = "";
    chatBody.scrollTop = chatBody.scrollHeight;

    // Simulate reply ONLY after sending a message
    if (responseIndex < responseQueue.length) {
        setTimeout(() => {
            receiveMessage(responseQueue[responseIndex]);
            responseIndex++;
        }, 1500); // Delay for realism
    }
}

function receiveMessage(text) {
    const messageElement = document.createElement("div");
    messageElement.classList.add("message", "received");
    messageElement.textContent = text;

    const chatBody = document.getElementById("chat-body");
    chatBody.appendChild(messageElement);
    chatBody.scrollTop = chatBody.scrollHeight;
}
</script>


</body>
</html>


