<div class="d-flex flex-column h-100">
    <div class="d-flex align-items-center justify-content-between bg-white px-3 py-1 rounded-0 border-0 border-bottom">
        <div class="d-flex align-items-center gap-2 flex-1">
            <div class="aspect-ratio-1x1 receiver_profile_img--container">
                <a href="">
                    <img class="rounded-circle object-fit-cover" height="36px" width="36px"
                        src="{{ $current_channel->other_subscriber && $current_channel->other_subscriber->user->profile_image ? asset($current_channel->other_subscriber->user->profile_image) : asset('assets/img/no-img-cover.jpg') }}"
                        alt="">
                </a>
                {{-- <img class="w-100 h-100 object-fit-cover" src="{{ asset('assets/img/ui/avatar_pp.png') }}" alt=""> --}}
            </div>
            <div class="d-flex flex-column text-start">
                <span
                    class="fw-bold">{{ $current_channel->is_group == 0 && $current_channel->other_subscriber ? $current_channel->other_subscriber->user->name : $current_channel->name }}</span>
                {{-- <span class="text-primary text-14">Typing...</span> --}}
            </div>
        </div>
        <div class="btn-group h-fit-content">
            <button type="button" class="btn post-three-dot-btn dropdown-toggle p-0 d-flex" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa-solid fa-ellipsis-vertical"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="">Delete</a></li>
            </ul>
        </div>
    </div>
    <div class="flex-1 d-flex flex-column align-items-center justify-content-center message-spinner-container">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div id="messages_container" class="flex-1 messages-container px-3 overflow-y-scroll customized__scrollbar pt-2"
        style="display: none;">
        @foreach ($messages as $message)
            @include('backend.pages.message.single-message')
        @endforeach
    </div>
    <div id="preview_images" class="d-flex"></div>
    <div class="d-flex px-3 py-2 bg-white gap-1 border-top border-bottom">
        <div class="d-flex gap-1">
            <input type="file" multiple name="image[]" accept="image/*, video/*"
                onchange="previewFiles('files', 'preview_images')" class="d-none" id="files">
            <div class="message-helper-btn d-flex flex-column align-items-center justify-content-center">
                <label for="files" class="btn border"><i class="fa-solid fa-paperclip"></i></label>
            </div>
            {{-- <div class="message-helper-btn d-flex flex-column align-items-center justify-content-center">
                    <button
                        class="btn border w-100 d-flex flex-column align-items-center justify-content-center h-100 microphone"><i
                            class="fa-solid fa-microphone"></i></button>
                </div> --}}

        </div>
        <div class="flex-1 position-relative">
            <textarea class="form-control position-absolute top-0 bottom-0 start-0 end-0" id="message-text" name="message-text"
                placeholder="Type Here..."></textarea>
        </div>
        <div>
            <button id="send_message_btn"
                class="btn message-helper-btn h-100 d-flex flex-column align-items-center justify-content-center btn-primary"><i
                    class="fa-regular fa-paper-plane"></i></button>
        </div>
    </div>
</div>
