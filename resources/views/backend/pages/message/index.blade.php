@section('js')
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.message-spinner-container').removeClass('d-flex').addClass('d-none');
                $('.messages-container').show();
                $('.messages-container').scrollTop($('.messages-container')[0].scrollHeight);
            }, 1000);
        })
    </script>

    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"
        integrity="sha384-mZLF4UVrpi/QTWPA7BjNPEnkIfRFn4ZEO3Qt/HFklTJBj/gBOV8G3HcKn4NfQblz" crossorigin="anonymous">
    </script>

    <script>
        function reloadChannelsContainer() {
            $.ajax({
                type: 'get',
                url: "{{ route('reload.channels.container') }}",
                dataType: 'html',
                success: function(html) {
                    $('#channels_container').html(html);
                },
                error: function(error) {
                    // Handle errors here
                }
            });
        }

        $(document).ready(function() {
            let ip_address = '127.0.0.1';
            let socket_port = '3000';
            let socket = io(`${ip_address}:${socket_port}`);
            let subscripers = @json($subscribers);
            let my_username = "{{ $my_username }}";
            let my_user_id = "{{ $my_user_id }}";
            let channel_id = "{{ $channel_id }}";

            socket.on('connection');

            let chatInput = $('#message-text');
            chatInput.keypress(function(e) {
                let message = $(this).val();
                let body = {
                    subscripers: subscripers,
                    sender: my_username,
                    message: message,
                    channel_id: channel_id,
                };
                if (e.which == 13 && !e.shiftKey) {
                    e.preventDefault();
                    $('#messages_container').append(`
                        <div class="d-flex gap-1 h-fit-content flex-row-reverse mb-3">
                            <div class="message-profile-pic-container aspect-ratio-1x1 overflow-hidden">
                                <img class="w-100 h-100 object-fit-cover" src="{{ asset('assets/img/ui/profile-pic.png') }}" alt="">
                            </div>
                            <div class="message-text-container">
                                <div class="text-gray-900 bg-secondary rounded p-3">${message}</div>
                                    <p class="ms-2 text-gray-500 text-12">2:00 PM</p>
                            </div>
                        </div>`);
                    $('.messages-container').scrollTop($('.messages-container')[0].scrollHeight);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        data: body,
                        url: "{{ route('chat.save') }}",
                        success: function(response) {
                            socket.emit('sendChatToServer', body);
                            chatInput.val('');
                            reloadChannelsContainer();
                        },
                        error: function(error) {
                            // Handle errors here
                        }
                    });
                }
            });

            socket.on(`sendChatToClient/${my_user_id}`, (body) => {
                reloadChannelsContainer();
                if (channel_id == body.channel_id) {
                    $('#messages_container').append(`
                        <div class="d-flex gap-1 h-fit-content mb-3">
                            <div class="message-profile-pic-container aspect-ratio-1x1 overflow-hidden">
                                <img class="w-100 h-100 object-fit-cover" src="{{ asset('assets/img/ui/profile-pic.png') }}" alt="">
                            </div>
                            <div class="message-text-container">
                                <div class="text-gray-900 bg-white rounded p-3">${body.message}</div>
                                    <p class="ms-2 text-gray-500 text-12">2:00 PM</p>
                            </div>
                        </div>`);
                    $('a[data-channel-id="' + body.channel_id + '"]').find('.last-message').text(body
                        .message);
                    $('.messages-container').scrollTop($('.messages-container')[0].scrollHeight);
                }
            });


        })
    </script>
@endsection