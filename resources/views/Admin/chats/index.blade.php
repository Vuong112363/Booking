@extends('adminlte::page')

@section('title', 'Quản lý Hỗ trợ Khách hàng')

@section('content_header')
    <h1><i class="fas fa-comments text-info"></i> Chat Hỗ Trợ Khách Hàng</h1>
@stop

@section('css')
<style>
    /* TUỲ CHỈNH THANH CUỘN (SLIM SCROLLBAR) */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* DANH SÁCH USER TÌM KIẾM */
    .user-list-container {
        height: 500px;
        overflow-y: auto;
    }
    .user-chat-item {
        transition: all 0.2s;
        border-left: 3px solid transparent;
        cursor: pointer;
    }
    .user-chat-item:hover {
        background-color: #f8fafc;
    }
    .user-chat-item.active {
        background-color: #f0f9ff;
        border-left: 3px solid #17a2b8; /* Màu info */
    }
    .user-avatar {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border-radius: 50%;
    }

    /* KHUNG CHAT & BONG BÓNG CHAT */
    .chat-panel-body {
        height: 400px;
        overflow-y: auto;
        padding: 1.5rem;
        background-color: #f8fafc; /* Nền xám rất nhạt cho dễ nhìn */
    }
    .chat-message {
        margin-bottom: 1.5rem;
        display: flex;
        flex-direction: column;
    }
    .chat-message.right { align-items: flex-end; }
    .chat-message.left { align-items: flex-start; }
    
    .chat-bubble {
        max-width: 75%;
        padding: 10px 15px;
        border-radius: 18px;
        font-size: 0.95rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        word-wrap: break-word;
    }
    
    /* Tin nhắn của Khách hàng */
    .chat-message.left.msg-user .chat-bubble {
        background-color: #ffffff;
        color: #334155;
        border: 1px solid #e2e8f0;
        border-bottom-left-radius: 4px;
    }
    /* Tin nhắn của Bot AI */
    .chat-message.left.msg-bot .chat-bubble {
        background: linear-gradient(135deg, #8b5cf6 0%, #3b82f6 100%);
        color: #ffffff;
        border-bottom-left-radius: 4px;
        box-shadow: 0 4px 6px rgba(139, 92, 246, 0.25);
    }
    /* Tin nhắn của Admin */
    .chat-message.right .chat-bubble {
        background-color: #17a2b8; /* Màu info / cyan */
        color: #ffffff;
        border-bottom-right-radius: 4px;
    }

    .chat-info {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 4px;
        margin-bottom: 2px;
    }
    
    /* TRẠNG THÁI TRỐNG */
    .empty-state {
        height: 500px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #f8fafc;
        border-radius: 0.25rem;
    }
    .empty-state-icon {
        font-size: 5rem;
        color: #e2e8f0;
        margin-bottom: 1rem;
    }
</style>
@stop

@section('content')
<div class="row">
    <div class="col-md-4 col-lg-3">
        <div class="card card-outline card-info shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold"><i class="fas fa-users text-info mr-1"></i> Khách hàng</h3>
            </div>
            <div class="card-body p-0 user-list-container">
                <ul class="list-unstyled mb-0" id="user-list">
                    @forelse($chatUsers as $user)
                        <li class="p-3 border-bottom user-chat-item user-chat-link" data-id="{{ $user->userid }}" data-name="{{ $user->username }}">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->username) }}&background=e0f2fe&color=0284c7&rounded=true" alt="Avatar" class="user-avatar shadow-sm mr-3">
                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="mb-0 text-truncate font-weight-bold text-dark">{{ $user->username }}</h6>
                                    <small class="text-muted"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($user->last_activity)->diffForHumans() }}</small>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="p-4 text-center text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 text-light"></i>
                            <p class="mb-0">Chưa có dữ liệu chat.</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8 col-lg-9">
        <div class="card card-outline card-info shadow-sm" id="chat-panel" style="display: none;">
            <div class="card-header bg-white d-flex align-items-center">
                <img id="current-chat-avatar" src="" alt="Avatar" class="img-circle border mr-2" style="width: 35px; height: 35px;">
                <h3 class="card-title font-weight-bold mb-0">Đang hỗ trợ: <span id="current-chat-name" class="text-info"></span></h3>
            </div>
            
            <div class="card-body p-0">
                <div class="chat-panel-body" id="admin-chat-body">
                    </div>
            </div>
            
            <div class="card-footer bg-white">
                <div class="input-group input-group-lg">
                    <input type="hidden" id="current-user-id" value="">
                    <input type="text" id="admin-chat-input" placeholder="Gõ câu trả lời của bạn vào đây..." class="form-control" autocomplete="off" style="border-radius: 20px 0 0 20px; font-size: 1rem;">
                    <span class="input-group-append">
                        <button type="button" id="admin-send-btn" class="btn btn-info px-4" style="border-radius: 0 20px 20px 0;">
                            <i class="fas fa-paper-plane"></i> Gửi
                        </button>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm empty-state" id="empty-chat-panel">
            <i class="fas fa-comment-dots empty-state-icon"></i>
            <h4 class="text-secondary font-weight-normal">Xin chào Admin!</h4>
            <p class="text-muted">Vui lòng chọn một khách hàng bên trái để bắt đầu hỗ trợ.</p>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.3/dist/echo.iife.js"></script>

<script>
$(document).ready(function() {
    let currentUserid = null;
    let echoChannel = null;

    // 1. Khởi tạo kết nối Pusher
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '{{ env('PUSHER_APP_KEY') }}',
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        forceTLS: true
    });

    // Cài đặt CSRF Token
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Cuộn xuống cuối
    function scrollToBottom() {
        let chatBody = $('#admin-chat-body');
        chatBody.scrollTop(chatBody[0].scrollHeight);
    }

    // Hàm render 1 bong bóng chat (UI MỚI)
    function renderMessage(msg, isUser, isBot) {
        let senderName = isUser ? 'Khách hàng' : (isBot ? 'Bot AI' : 'Bạn (Admin)');
        let alignment = isUser ? 'left' : 'right';
        let typeClass = isUser ? 'msg-user' : (isBot ? 'msg-bot' : 'msg-admin');
        let icon = isBot ? '<i class="fas fa-robot mr-1"></i> ' : '';

        // Chống XSS (Mã hóa HTML)
        let textSafe = $('<div>').text(msg.message).html().replace(/\n/g, '<br>');

        return `
        <div class="chat-message ${alignment} ${typeClass}">
            <div class="chat-info">
                ${icon}<strong>${senderName}</strong> • ${msg.createdat}
            </div>
            <div class="chat-bubble">
                ${textSafe}
            </div>
        </div>`;
    }

    // Load tin nhắn
    function loadMessages(userid) {
        $.get("{{ url('/admin/chats/fetch') }}/" + userid, function(res) {
            if(res.status === 'success') {
                $('#admin-chat-body').empty();
                
                let allHtml = ''; 
                res.messages.forEach(function(msg) {
                    let isUser = msg.adminid == 0;
                    let isBot = msg.adminid == 999;
                    allHtml += renderMessage(msg, isUser, isBot);
                });
                
                $('#admin-chat-body').append(allHtml);
                setTimeout(scrollToBottom, 100); // Thêm delay nhỏ để ảnh/DOM kịp render
            }
        });
    }

    // Xử lý khi click vào 1 user bên danh sách
    $('.user-chat-link').click(function(e) {
        e.preventDefault();
        
        $('.user-chat-link').removeClass('active');
        $(this).addClass('active');

        $('#empty-chat-panel').hide();
        $('#chat-panel').show();

        // Lấy thông tin user
        currentUserid = $(this).data('id');
        let userName = $(this).data('name');
        
        $('#current-user-id').val(currentUserid);
        $('#current-chat-name').text(userName);
        $('#current-chat-avatar').attr('src', `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=e0f2fe&color=0284c7&rounded=true`);

        // Load tin nhắn
        loadMessages(currentUserid);

        // PUSHER
        if (echoChannel) {
            window.Echo.leave(echoChannel);
            echoChannel = null;
        }
        
        echoChannel = 'chat-room.' + currentUserid;
        window.Echo.channel(echoChannel)
            .listen('.new-message', (data) => {
                if (data.senderClass === 'msg-admin') return;
                let isUser = data.senderClass === 'msg-user';
                let isBot = data.senderClass === 'msg-bot';
                
                let simulatedMsg = {
                    message: data.message,
                    createdat: new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' }),
                    adminid: isUser ? 0 : (isBot ? 999 : 1)
                };

                $('#admin-chat-body').append(renderMessage(simulatedMsg, isUser, isBot));
                scrollToBottom();
            });
    });

    // Xử lý gửi tin nhắn của Admin
    function sendAdminMessage() {
        let text = $('#admin-chat-input').val().trim();
        let userid = $('#current-user-id').val();
        
        if(text === '' || !userid) return;

        // Xóa input
        $('#admin-chat-input').val('').focus();

        // ĐÃ FIX LỖI Ở ĐÂY: Hiển thị ngay tin nhắn admin lên màn hình
        let simulatedMsg = {
            message: text,
            createdat: new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' }),
            adminid: 1
        };
        $('#admin-chat-body').append(renderMessage(simulatedMsg, false, false));
        scrollToBottom();

        // Gửi lên server
        $.post("{{ url('/admin/chats/send') }}", { userid: userid, message: text }, function(res) {
            if(res.status !== 'success') {
                alert('Lỗi: ' + res.message);
            }
        }).fail(function() {
            alert('Lỗi đường truyền! Vui lòng thử lại.');
        });
    }

    $('#admin-send-btn').click(function() { sendAdminMessage(); });
    $('#admin-chat-input').keypress(function(e) {
        if(e.which == 13) sendAdminMessage();
    });

});
</script>
@stop