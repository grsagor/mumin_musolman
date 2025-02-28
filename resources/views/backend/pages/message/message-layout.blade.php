@extends('backend.layout.app')
@section('title', 'Message')
@section('content')
    <div class="row border-start me-0 g-0">
        <div class="{{ $channel_id ? '' : 'd-none d-lg-block' }} col-12 col-lg-7 p-0 full-height">
            @yield('message-content')
        </div>
        <div
            class="{{ $channel_id ? 'd-none d-lg-block' : '' }} col-12 col-lg-5 border-start p-3 pt-0 full-height overflow-y-scroll customized__scrollbar">
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

        .full-height {
            height: calc(100vh - 80px) !important;
        }

        /* @media (max-width: 991px) {
                        .no_channel_id {
                            display: none;
                        }
                    } */
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
        })
    </script>

    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"
        integrity="sha384-mZLF4UVrpi/QTWPA7BjNPEnkIfRFn4ZEO3Qt/HFklTJBj/gBOV8G3HcKn4NfQblz" crossorigin="anonymous">
    </script>

    <script>
        let socket = io(`https://socket.grsagor.com`);

        socket.on('connect', function() {
            console.log('Connected to the server.');
        });

        socket.on('disconnect', function() {
            console.log('Disconnected from the server.');
        });

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
                var currentDate = new Date();
                var formattedTime = currentDate.toLocaleTimeString([], {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                });
                $('#files').val('');
                $('#preview_images').empty();
                $('#messages_container').append(
                    `<div class="d-flex gap-1 h-fit-content flex-row-reverse mb-3"><div class="message-profile-pic-container aspect-ratio-1x1 overflow-hidden"><img class="rounded-circle object-fit-cover" height="36px" width="36px" src="/${user.profile_image}" alt=""></div><div class="message-text-container  d-flex flex-column align-items-end">${ message ? `<div class="text-gray-900 bg-secondary rounded p-3">${message}</div>` : '' }<div class="mt-2 d-flex gap-1" id="imageContainer">${socketFiles.map(file => {if (file.type === 'image') {return `<img width="100" height="100" class="object-fit-cover" src="${file.path}" alt="">`;} else if(file.type === 'video') { return ` <
                    video controls src = "${file.path}"
                    width = "100"
                    height = "100"
                    autoplay > < /video>`; } else { return ''; } }).join('') } </div > < p class =
                "ms-2 text-gray-500 text-12" > $ {
                    formattedTime
                } < /p></div > < /div>`);

                    $('.messages-container').scrollTop($('.messages-container')[0].scrollHeight); $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: body,
                        url: "{{ route('chat.save') }}",
                        success: function(response) {
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
                        socket.on(`get-message/{{ $channel_id }}`, (body) => {
                                reloadChannelsContainer();
                                var currentDate = new Date();
                                var formattedTime = currentDate.toLocaleTimeString([], {
                                    hour: 'numeric',
                                    minute: '2-digit',
                                    hour12: true
                                });
                                if (channel_id == body.channel_id && my_user_id != body.user_id) {
                                    $('#messages_container').append(
                                        `<div class="d-flex gap-1 h-fit-content mb-3"><div class="message-profile-pic-container aspect-ratio-1x1 overflow-hidden"><img class="rounded-circle object-fit-cover" height="36px" width="36px" src="{{ asset('') }}${body.user.profile_image}" alt=""></div><div class="message-text-container">${ body.message ? `<div class="text-gray-900 bg-white rounded p-3">${body.message}</div>` : '' }<div class="mt-2 d-flex gap-1" id="imageContainer">${body.files ? body.files.map(file => { if (file.type === 'image') { return `<img width="100" height="100" class="object-fit-cover" src="${file.path}" alt="">`; } else if(file.type === 'video') { return ` <
                                        video controls src = "${file.path}"
                                        width = "100"
                                        height = "100"
                                        autoplay > < /video>`; } else { return ''; } }).join(''): '' } </div > <
                                    p class = "ms-2 text-gray-500 text-12" > $ {
                                        formattedTime
                                    } < /p></div > < /div>`);

                                        $('a[data-channel-id="' + body.channel_id + '"]').find('.last-message')
                                        .text(body.message); $('.messages-container').scrollTop($(
                                            '.messages-container')[0].scrollHeight);
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
            });

            $('#message_delete_button').click(function() {
                const channel_id = "{{ $channel_id }}";
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "POST",
                            url: "{{ route('admin.chat.hide') }}",
                            data: {
                                channel_id: channel_id
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data.success) {
                                    $.toast({
                                        heading: 'Success',
                                        text: data.message,
                                        position: 'top-center',
                                        icon: 'success'
                                    });
                                    window.location.href = "{{ route('admin.message') }}"
                                } else {
                                    $.toast({
                                        heading: 'Error',
                                        text: data.message,
                                        position: 'top-center',
                                        icon: 'error'
                                    });
                                }
                            }
                        })

                    }
                })
            })
        })

        function previewFiles(input, preview) {
            var files = $("#" + input + "").get(0).files;
            var selectedFiles = [];

            if (files.length > 0) {
                for (var i = 0; i < files.length; i++) {
                    var reader = new FileReader();
                    var file = files[i];

                    reader.onload = (function(file) {
                        return function(e) {
                            var mediaContainer = $("<div>").addClass("media-container position-relative");
                            var mediaElement;

                            if (file.type.startsWith('image/')) {
                                // If the file is an image
                                mediaElement = $("<img>").attr("src", e.target.result).attr("height", "60px")
                                    .attr("width", "60px");
                            } else if (file.type.startsWith('video/')) {
                                // If the file is a video
                                mediaElement = $("<video controls>").attr("src", e.target.result).attr("height",
                                    "60px").attr("width", "60px");
                            } else {
                                // Unsupported file type, skip preview
                                return;
                            }

                            mediaElement.addClass("preview_media m-1 border").appendTo(mediaContainer);

                            var removeButton = $("<a>")
                                .addClass(
                                    "position-absolute top-0 end-0 rounded-circle bg-danger text-light px-1")
                                .html('<i class="fa-solid fa-xmark"></i>')
                                .click(function() {
                                    // Remove the media container when the remove button is clicked
                                    $(this).closest(".media-container").remove();

                                    // Remove the corresponding file from the selectedFiles array
                                    var indexToRemove = selectedFiles.indexOf(file);
                                    if (indexToRemove !== -1) {
                                        selectedFiles.splice(indexToRemove, 1);
                                    }

                                    // Update the file input with the new set of selected files
                                    $("#" + input + "").prop("files", new FileListFromArray(selectedFiles));
                                })
                                .appendTo(mediaContainer);

                            mediaContainer.appendTo("#" + preview + "");

                            // Add the file to the selectedFiles array
                            selectedFiles.push(file);
                        };
                    })(file);

                    reader.readAsDataURL(file);
                }
            }
        }
    </script>
@endsection
