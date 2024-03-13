@extends('backend.layout.app')
@section('title', 'Message')
@section('content')
    <div class="row border-start me-0">
        <div class="col-7 p-0 vh-100">
            @yield('message-content')
        </div>
        <div class="col-5 border-start p-3 pt-0 vh-100 overflow-y-scroll customized__scrollbar">
            @include('backend.pages.message.message-right-side')
        </div>
    </div>
@endsection

@section('css')
    <style>
        .receiver_profile_img--container {
            width: 36px;
        }

        .message-profile-pic-container {
            width: 36px;
            height: 36px;
        }

        .message-text-container {
            max-width: 60%;
        }

        #message-text {
            resize: none;
        }

        .message-helper-btn {
            width: 40px;
        }

        .active-dot-container {
            width: 12px;
            border: 2px solid white;
        }

        .unlock-page-img-container {
            width: 100px;
        }

        .unlock-page-img-container .active-dot-container {
            width: 24px;
            bottom: 14px !important;
            right: 5px !important;
        }
    </style>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('.microphone').click(function() {
                $(this).find('i').toggleClass('fa-microphone fa-microphone-slash');
            })
            setTimeout(function() {
                $('.message-spinner-container').removeClass('d-flex').addClass('d-none');
                $('.messages-container').show();
                $('.messages-container').scrollTop($('.messages-container')[0].scrollHeight);
            }, 1000);

            $('.chat_unlock_modal_open_btn').click(function() {
                $('#chatUnlockModal').modal('show');
            })

            $(document).on('click', '#chatSubscribeBtn', function(e) {
                e.preventDefault();
                let go_next_step = true;
                if ($(this).attr('data-check-area') && $(this).attr('data-check-area').trim() !== '') {
                    go_next_step = check_validation_Form('#chatSubscribeModalForm .' + $(this).attr(
                        'data-check-area'));
                }
                if (go_next_step == true) {
                    let payby = $('#chatUnlockModal input:radio[name="choose_card"]:checked').val();
                    if (payby == 'Wallet Credit') {
                        let form = document.getElementById('chatSubscribeModalForm');
                        var formData = new FormData(form);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: $('#chatSubscribeModalForm').attr('action'),
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response.type == 'Success') {
                                    $.toast({
                                        heading: response.type,
                                        text: response.message,
                                        position: 'top-center',
                                        icon: response.icon
                                    })
                                    location.reload();
                                    $('#chatUnlockModal').modal('hide');
                                } else {
                                    $.toast({
                                        heading: response.type,
                                        text: response.message,
                                        position: 'top-center',
                                        icon: response.icon
                                    })
                                }
                            },
                            error: function(xhr) {
                                let errorMessage = '';
                                $.each(xhr.responseJSON.errors, function(key, value) {
                                    errorMessage += ('' + value + '<br>');
                                });
                                $('#chatUnlockModal .server_side_error').empty();
                                $('#chatUnlockModal .server_side_error').html(
                                    '<div class="alert alert-danger" role="alert">' +
                                    errorMessage +
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                                    );
                            },
                        })
                    } else {
                        let handler = PaystackPop.setup({
                            key: 'pk_test_2e8d2c136a6976fa91a3b5338edf49a3f693d989', // Replace with your public key
                            email: '{{ Auth::user()->email }}',
                            amount: Number($(
                                '#chatUnlockModal input:radio[name="subscribe_plan"]:checked'
                                ).attr('data-price')) * Number(
                                {{ Helper::getSettings('currency_rate_per_usd') }}),
                            ref: '' + Math.floor((Math.random() * 1000000000) + 1),
                            onClose: function() {
                                location.reload();
                            },
                            callback: function(response) {
                                if (response.status == 'success') {
                                    let form = document.getElementById(
                                    'chatSubscribeModalForm');
                                    var formData = new FormData(form);
                                    formData.append('payment_status', response.status)
                                    formData.append('trxref', response.trxref)
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                                .attr('content')
                                        },
                                        url: $('#chatSubscribeModalForm').attr(
                                            'action'),
                                        type: "POST",
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                            if (response.type == 'Success') {
                                                $.toast({
                                                    heading: response.type,
                                                    text: response.message,
                                                    position: 'top-center',
                                                    icon: response.icon
                                                })
                                                location.reload();
                                                $('#chatUnlockModal').modal('hide');
                                            } else {
                                                $.toast({
                                                    heading: response.type,
                                                    text: response.message,
                                                    position: 'top-center',
                                                    icon: response.icon
                                                })
                                            }
                                        },
                                        error: function(xhr) {
                                            let errorMessage = '';
                                            $.each(xhr.responseJSON.errors,
                                                function(key, value) {
                                                    errorMessage += ('' +
                                                        value + '<br>');
                                                });
                                            $('#chatUnlockModal .server_side_error')
                                                .empty();
                                            $('#chatUnlockModal .server_side_error')
                                                .html(
                                                    '<div class="alert alert-danger" role="alert">' +
                                                    errorMessage +
                                                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
                                                    );
                                        },
                                    })
                                } else {
                                    $.toast({
                                        heading: "Error",
                                        text: "Payment " + response.status,
                                        position: 'top-center',
                                        icon: "error"
                                    })
                                }
                            }
                        })
                        handler.openIframe();
                    }
                }
            })
        })
    </script>

    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"
        integrity="sha384-mZLF4UVrpi/QTWPA7BjNPEnkIfRFn4ZEO3Qt/HFklTJBj/gBOV8G3HcKn4NfQblz" crossorigin="anonymous">
    </script>

    <script>
        let ip_address = '127.0.0.1';
        let socket_port = '3000';
        let socket = io(`${ip_address}:${socket_port}`);
        let chatInput = $('#message-text');
        let subscripers = @json($subscribers);
        let user = @json(Auth::user());
        let my_username = "{{ $my_username }}";
        let my_user_id = "{{ $my_user_id }}";
        let channel_id = "{{ $channel_id }}";

        function reloadChannelsContainer(name = null) {
            var data = {
                name: name
            }
            $.ajax({
                type: 'get',
                url: "{{ route('reload.channels.container') }}",
                data: data,
                dataType: 'html',
                success: function(html) {
                    $('#channels_container').html(html);
                },
                error: function(error) {
                    // Handle errors here
                }
            });
        }

        function sendMessage() {
            socket.on('connection');
            let message = $('#message-text').val();
            var files = $('#files')[0].files;

            if (message.trim() != '' || files.length != 0) {
                var socketFiles = [];
            var body = new FormData();
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var fileType = "";
                if (file.type.startsWith('image/')) {
                    fileType = 'image';
                } else if (file.type.startsWith('video/')) {
                    fileType = 'video';
                } else {
                    fileType = 'document';
                }
                var filePath = URL.createObjectURL(file);
                socketFiles.push({
                    type: fileType,
                    path: filePath
                });
                body.append('files[]', file);
            }

            body.append('subscripers', subscripers);
            body.append('sender', my_username);
            body.append('senderInfo', user);
            body.append('message', message);
            body.append('channel_id', channel_id);
            body.append('socketFiles', socketFiles);

            var socketBody = {
                subscripers: subscripers,
                sender: my_username,
                senderInfo: user,
                message: message,
                channel_id: channel_id,
                socketFiles: socketFiles,
            }
            var currentDate = new Date();
            var formattedTime = currentDate.toLocaleTimeString([], {
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });
            $('#files').val('');
            $('#preview_images').empty();
            $('#messages_container').append(`
                        <div class="d-flex gap-1 h-fit-content flex-row-reverse mb-3">
                            <div class="message-profile-pic-container aspect-ratio-1x1 overflow-hidden">
                                <img class="rounded-circle object-fit-cover" height="36px" width="36px" src="/uploads/user-images/${user.profile_image}" alt="">
                            </div>
                            <div class="message-text-container  d-flex flex-column align-items-end">
                                ${ message ? `<div class="text-gray-900 bg-secondary rounded p-3">${message}</div>` : '' }
                                <div class="mt-2 d-flex gap-1" id="imageContainer">
                                    ${
                                        socketFiles.map(file => {
                                            if (file.type === 'image') {
                                                return `<img width="100" height="100" class="object-fit-cover" src="${file.path}" alt="">`;
                                            } else if(file.type === 'video') {
                                                return `<video controls src="${file.path}" width="100" height="100" autoplay></video>`;
                                            } else {
                                                return '';
                                            }
                                        }).join('')
                                    }
                                </div>
                                <p class="ms-2 text-gray-500 text-12">${formattedTime}</p>
                            </div>
                        </div>`);

            $('.messages-container').scrollTop($('.messages-container')[0].scrollHeight);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                processData: false,
                contentType: false,
                data: body,
                url: "{{ route('chat.save') }}",
                success: function(response) {
                    socketBody.fullMessage = response.fullMessage;
                    socket.emit('sendChatToServer', socketBody);
                    chatInput.val('');
                    reloadChannelsContainer();
                },
                error: function(error) {
                    // Handle errors here
                }
            });
            }
        }

        $(document).ready(function() {
        let chatInput = $('#message-text');
        chatInput.keypress(function(e) {
            if (e.which == 13 && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
        let my_user_id = "{{ $my_user_id }}";
        socket.on(`sendChatToClient/${my_user_id}`, (body) => {
                    reloadChannelsContainer();
                    var currentDate = new Date();
                    var formattedTime = currentDate.toLocaleTimeString([], {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true
                    });
                    if (channel_id == body.channel_id) {
                        $('#messages_container').append(`
                        <div class="d-flex gap-1 h-fit-content mb-3">
                            <div class="message-profile-pic-container aspect-ratio-1x1 overflow-hidden">
                                <img class="rounded-circle object-fit-cover" height="36px" width="36px" src="{{ asset('uploads/user-images/') }}/${body.senderInfo.profile_image}" alt="">
                            </div>
                            <div class="message-text-container">
                                ${ body.message ? `<div class="text-gray-900 bg-white rounded p-3">${body.message}</div>` : '' }
                                <div class="mt-2 d-flex gap-1" id="imageContainer">
                                    ${
                                        body.fullMessage.files ?
                                        body.fullMessage.files.map(file => {
                                            if (file.type === 'image') {
                                                return `<img width="100" height="100" class="object-fit-cover" src="/${file.path}" alt="">`;
                                            } else if(file.type === 'video') {
                                                return `<video controls src="/${file.path}" width="100" height="100" autoplay></video>`;
                                            } else {
                                                return '';
                                            }
                                        }).join('')
                                        : ''
                                    }
                                </div>
                                    <p class="ms-2 text-gray-500 text-12">${formattedTime}</p>
                            </div>
                        </div>`);
        $('a[data-channel-id="' + body.channel_id + '"]').find('.last-message').text(body
            .message);
        $('.messages-container').scrollTop($('.messages-container')[0].scrollHeight);
        }
        });


        })
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('input', '#search', function() {
                var name = $(this).val();
                reloadChannelsContainer(name);
            })

            $(document).on('click', '#send_message_btn', function() {
                sendMessage();
            })
        })
    </script>
@endsection
