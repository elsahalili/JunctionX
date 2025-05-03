<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AI Chat UI</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8fafd;
      display: flex;
      height: 100vh;
      justify-content: center;
      align-items: center;
    }

    .chat-wrapper {
      width: 100%;
      max-width: 700px;
      background: white;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .chat-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: #ffffff;
      padding: 16px 20px;
      border-bottom: 1px solid #eee;
    }

    .chat-header h2 {
      margin: 0;
      font-size: 20px;
      font-weight: 600;
    }

    .status {
      display: flex;
      align-items: center;
      font-size: 14px;
    }

    .status::before {
      content: '';
      display: inline-block;
      width: 8px;
      height: 8px;
      background: #2ecc71;
      border-radius: 50%;
      margin-right: 6px;
    }

    .chat-body {
      padding: 20px;
      overflow-y: auto;
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 10px;
      background: #f4f7f9;
    }

    .message {
      max-width: 70%;
      padding: 12px 16px;
      border-radius: 16px;
      font-size: 14px;
      line-height: 1.4;
    }

    .message.received {
      background: #e8f0fe;
      align-self: flex-start;
    }

    .message.sent {
      background: #dcf8c6;
      align-self: flex-end;
    }

    .chat-input {
      display: flex;
      align-items: center;
      padding: 12px 20px;
      background: #ffffff;
      border-top: 1px solid #eee;
    }

    .chat-input input {
      flex: 1;
      padding: 10px 16px;
      border: none;
      border-radius: 20px;
      background: #f0f2f5;
      margin-right: 10px;
      font-size: 14px;
    }

    .chat-input button,
    .chat-input i {
      background: none;
      border: none;
      font-size: 18px;
      color: #888;
      cursor: pointer;
      margin-left: 8px;
    }

    .chat-input button.send {
      background-color: #8b5cf6;
      color: white;
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 14px;
    }
    .chat-header {
    display: flex;
    align-items: center;
    justify-content: flex-start; /* changed */
    gap: 10px; /* add spacing between back button and title */
        }

  </style>
</head>
<body>
  <div class="chat-wrapper">
    <div class="chat-header">
    <button id="back-button" style="background: none; border: none; font-size: 15px; color: #333; cursor: pointer;">
        <i class="fas fa-arrow-left"></i>
    </button>
      <h2>Alice</h2>
      <div class="status">Online</div>
    </div>

    <div class="chat-body" id="chat-body"></div>

    <div class="chat-input">
      <i class="fas fa-paperclip"></i>
      <i class="fas fa-microphone"></i>
      <input type="text" id="message-input" placeholder="Type your message..." />
      <button class="send" id="send-btn"><i class="fas fa-paper-plane"></i></button>
    </div>
  </div>

  <script>
  window.addEventListener("load", () => {
    const sendBtn = document.getElementById("send-btn");
    const messageInput = document.getElementById("message-input");
    const chatBody = document.getElementById("chat-body");

    const replies = [
      "Sure, I'm here to help!",
      "Can you tell me more about what you're looking for?",
      "Great! Let's get started.",
      "Feel free to ask any question."
    ];
    let replyIndex = 0;

    function addMessage(text, type = "sent") {
      const message = document.createElement("div");
      message.classList.add("message", type);
      message.textContent = text;
      chatBody.appendChild(message);
      chatBody.scrollTop = chatBody.scrollHeight;
    }

    function typeMessage(text) {
      const message = document.createElement("div");
      message.classList.add("message", "received");
      chatBody.appendChild(message);

      let index = 0;
      const typingInterval = setInterval(() => {
        if (index < text.length) {
          message.textContent += text.charAt(index);
          index++;
        } else {
          clearInterval(typingInterval);
        }
        chatBody.scrollTop = chatBody.scrollHeight;
      }, 50);
    }

    function sendMessage() {
      const text = messageInput.value.trim();
      if (!text) return;

      addMessage(text, "sent");
      messageInput.value = "";

      if (replyIndex < replies.length) {
        setTimeout(() => {
          addMessage(replies[replyIndex], "received");
          replyIndex++;
        }, 1200);
      }
    }

    sendBtn.addEventListener("click", sendMessage);
    messageInput.addEventListener("keydown", (e) => {
      if (e.key === "Enter") sendMessage();
    });

    // Show welcome message with typing animation
    setTimeout(() => {
      typeMessage("Hello! I'm your AI assistant Alice. How can I help you today?");
    }, 1500);
  });
</script>
<script>
  document.getElementById("back-button").addEventListener("click", () => {
    window.location.href = "universityPage.php?name=LSE";
  });
</script>




</body>
</html>
