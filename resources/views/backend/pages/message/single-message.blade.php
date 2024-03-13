<div class="d-flex gap-1 h-fit-content mb-3 {{ $message->user_id == $my_user_id ? 'flex-row-reverse' : '' }}">
    <div class="message-profile-pic-container aspect-ratio-1x1 overflow-hidden">
        <img class="rounded-circle object-fit-cover" height="36px" width="36px"
            src="{{ optional($message->user)->profile_image ? asset('uploads/user-images/' . $message->user->profile_image) : asset('assets/img/no-img-cover.jpg') }}"
            alt="">
    </div>
    <div class="message-text-container d-flex flex-column {{ $message->user_id == $my_user_id ? 'align-items-end' : 'align-items-start' }}">
        @if ($message->message)
            <div class="text-gray-900 rounded p-3 {{ $message->user_id == $my_user_id ? 'bg-secondary' : 'bg-white' }}">
                {{ $message->message }}</div>
        @endif
        @if ($message->files)
            <div class="mt-2 d-flex gap-1">
                @foreach ($message->files as $file)
                    @if ($file->type == 'image')
                        <img width="100" height="100" class="object-fit-cover" src="{{ asset($file->path) }}"
                            alt="">
                    @endif
                    @if ($file->type == 'video')
                        <video controls src="{{ asset($file->path) }}" width="100" height="100" autoplay></video>
                    @endif
                @endforeach
            </div>
        @endif
        <p class="ms-2 text-gray-500 text-12">{{ date('h:i a', strtotime($message->created_at)) }}</p>
    </div>
</div>
