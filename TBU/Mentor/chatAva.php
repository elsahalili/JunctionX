<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Clone - Ava</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background: linear-gradient(135deg, #d4fc79, #96e6a1);
        }

        .chat-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background-color: #1e272e;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .profile {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #fff;
            margin-bottom: 10px;
        }

        .username {
            font-size: 18px;
            font-weight: bold;
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
            transition: transform 0.2s ease;
        }

        .contact-item:hover {
            transform: scale(1.1);
        }

        .contact-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .chat-window {
            flex: 1;
            background: url('https://i.imgur.com/YrKvwyG.jpeg');
            background-size: cover;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background-color: #00b894;
            padding: 20px;
            color: white;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chat-body {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .chat-input {
            display: flex;
            padding: 15px;
            background-color: #ecf0f1;
            border-top: 2px solid #bdc3c7;
        }

        .chat-input input {
            flex: 1;
            padding: 10px;
            border-radius: 10px;
            border: 2px solid #7f8c8d;
            font-size: 16px;
        }

        .chat-input button {
            padding: 10px 20px;
            margin-left: 10px;
            border: none;
            border-radius: 10px;
            background-color: #00b894;
            color: white;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .chat-input button:hover {
            background-color: #019874;
        }

        .message {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 15px;
            font-size: 15px;
            line-height: 1.5;
        }

        .sent {
            align-self: flex-end;
            background-color: #55efc4;
        }

        .received {
            align-self: flex-start;
            background-color: #ffeaa7;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="sidebar">
            <div class="profile">
                <img src="blerton.jpg" alt="Profile Picture">
                <span class="username">Blerton Hamzai</span>
            </div>
            <ul class="contact-list">
                <li class="contact-item">
                    <img src="https://www.yourtango.com/sites/default/files/image_blog/things-strong-secure-stable-women-do-different.png" alt="Ava" class="contact-image">
                    <a href="ava.php" style="text-decoration: none; color: white;">Ava</a>
                </li>
            </ul>
        </div>

        <div class="chat-window">
            <div class="chat-header">
                <img src="https://www.yourtango.com/sites/default/files/image_blog/things-strong-secure-stable-women-do-different.png" height="50px" width="50px" style="border-radius: 50%;">
                Ava
            </div>

            <div class="chat-body" id="chat-body">
                <!-- Messages will appear here -->
            </div>

            <div class="chat-input">
                <input type="text" id="message-input" placeholder="Type a message...">
                <button id="send-btn">Send</button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("send-btn").addEventListener("click", sendMessage);
        document.getElementById("message-input").addEventListener("keydown", function (event) {
            if (event.key === "Enter") {
                sendMessage();
            }
        });

        function sendMessage() {
            const messageInput = document.getElementById("message-input");
            const messageText = messageInput.value.trim();
            if (messageText === "") return;

            const messageElement = document.createElement("div");
            messageElement.classList.add("message", "sent");
            messageElement.textContent = messageText;
            document.getElementById("chat-body").appendChild(messageElement);
            messageInput.value = "";
            scrollToBottom();
        }

        function receiveMessage(text) {
            const messageElement = document.createElement("div");
            messageElement.classList.add("message", "received");
            messageElement.textContent = text;
            document.getElementById("chat-body").appendChild(messageElement);
            scrollToBottom();
        }

        function scrollToBottom() {
            const chatBody = document.getElementById("chat-body");
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        // Ava's automatic replies
        setTimeout(() => receiveMessage("Ava: Hey bestie 😄"), 2000);
        setTimeout(() => receiveMessage("Ava: You free today?"), 8000);
        setTimeout(() => receiveMessage("Ava: Let’s go to the beach 🌊👙"), 15000);
        setTimeout(() => receiveMessage("Ava: I'll bring snacks! 🍓🍕"), 25000);
    </script>
</body>
</html>
