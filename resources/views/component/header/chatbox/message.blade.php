<style>
    /* Icon chat */
    #chat-icon {
        position: fixed;
        bottom: 135px;
        right: 25px;
        width: 60px;
        height: 60px;
        background-color: #007bff;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        cursor: pointer;
        z-index: 10000;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease;
    }

    #chat-icon:hover {
        background-color: #0056b3;
    }

    /* Hộp chat */
    #chatbox {
        position: fixed;
        bottom: 10%;
        right: 25px;
        width: 360px;
        max-height: 500px;
        display: flex;
        flex-direction: column;
        border: 1px solid #ccc;
        border-radius: 10px;
        background: #fff;
        font-family: 'Segoe UI', sans-serif;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        z-index: 9999;
        overflow: hidden;
    }

    /* Vùng tin nhắn */
    #messages {
        flex: 1;
        padding: 12px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .message-wrapper {
        display: flex;
        width: 100%;
    }

    .message {
        padding: 10px 15px;
        border-radius: 18px;
        max-width: 75%;
        font-size: 14px;
        line-height: 1.5;
        word-wrap: break-word;
    }

    .message.user {
        background-color: #0084ff;
        color: white;
        margin-left: auto;
        border-bottom-right-radius: 0;
    }

    .message.bot {
        background-color: #f1f0f0;
        color: #333;
        margin-right: auto;
        border-bottom-left-radius: 0;
    }

    .message.bot a {
        color: #007bff;
        text-decoration: none;
    }

    .message.bot a:hover {
        text-decoration: underline;
    }

    /* Ô input và nút gửi */
    #input-area {
        display: flex;
        border-top: 1px solid #ddd;
    }

    #input-area input {
        flex: 1;
        border: none;
        padding: 12px;
        font-size: 14px;
        outline: none;
        border-radius: 0;
    }

    #input-area button {
        padding: 12px 16px;
        background-color: #007bff;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    #input-area button:hover {
        background-color: #0056b3;
    }

    /* Responsive cho thiết bị nhỏ */
    @media (max-width: 480px) {
        #chatbox {
            width: 95%;
            right: 2.5%;
        }

        #chat-icon {
            right: 15px;
            bottom: 15px;
        }
    }
</style>

<!-- Icon chat (hiện luôn) -->
<div id="chat-icon">
    💬
</div>

<!-- Chatbox (ẩn ban đầu) -->
<div id="chatbox" style="display: none;">
    <div id="messages">
        <!-- Tin nhắn sẽ hiển thị ở đây -->
    </div>
    <div id="input-area">
        <input type="text" id="messageInput" placeholder="Nhập câu hỏi về sản phẩm..." maxlength="500">
        <button id="sendBtn">Gửi</button>
    </div>
</div>

<script>
    $(document).ready(function() {

        // Khi nhấn phím Enter trong ô input thì gọi sự kiện click nút Gửi
        $('#messageInput').keydown(function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Ngăn submit form nếu có
                $('#sendBtn').click(); // Gọi hàm gửi
            }
        });



        $('#chat-icon').click(function() {
            $('#chatbox').toggle();
            $('#messageInput').focus();
        });

        $('#sendBtn').click(function() {
            const message = $('#messageInput').val().trim();
            if (message === '') return;

            // Hiển thị tin nhắn của người dùng
            appendMessage(message, 'user');

            $.ajax({
                url: "{{ route('api.chatbox') }}",
                type: "POST",
                data: {
                    inputClient: message,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.data.length > 0) {
                        let reply = 'Sản phẩm liên quan:<br>';
                        response.data.forEach(product => {
                            reply +=
                                `• <a href="/cart/${product.product_id}">${product.product_name}</a><br>`;
                        });
                        appendMessage(reply, 'bot');
                    } else {
                        appendMessage('Không tìm thấy sản phẩm liên quan.', 'bot');
                    }
                },
                error: function() {
                    appendMessage('Lỗi khi gửi tin nhắn đến server.', 'bot');
                }
            });

            // Clear ô input
            $('#messageInput').val('');
        });

        // Hàm hiển thị tin nhắn
        function appendMessage(text, sender) {
            const wrapper = $('<div>').addClass('message-wrapper');
            const msg = $('<div>').addClass('message').addClass(sender).html(text);
            wrapper.append(msg);
            $('#messages').append(wrapper);
            $('#messages').scrollTop($('#messages')[0].scrollHeight);
        }

    });
</script>
