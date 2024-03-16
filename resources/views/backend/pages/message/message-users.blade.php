@foreach ($channels as $channel)
    <a data-channel-id="{{ $channel->id }}" href="{{ route('admin.message', ['channel_id' => $channel->id]) }}"
        class="text-gray-900 d-flex align-items-center justify-content-between bg-white px-3 py-1 border-0 rounded mb-2 cursor-pointer">
        <div class="d-flex align-items-center gap-2 flex-1">
            <div class="aspect-ratio-1x1 receiver_profile_img--container position-relative">
                <div class="rounded-circle overflow-hidden">
                    <img class="rounded-circle object-fit-cover" height="36px" width="36px" src="{{ $channel->other_subscriber && $channel->other_subscriber->user && $channel->other_subscriber->user->profile_image ? asset('uploads/user-images/' . $channel->other_subscriber->user->profile_image) : asset('assets/img/no-img-cover.jpg') }}"
                        alt="">
                </div>
                <div
                    class="active-dot-container aspect-ratio-1x1 overflow-hidden d-flex flex-column align-items-center justify-content-center position-absolute rounded-circle bottom-0 end-0">
                    <i class="fa-solid fa-circle text-12 text-success-500"></i>
                </div>
            </div>
            <div class="d-flex flex-column text-start">
                <span class="fw-bold">{{ $channel->other_subscriber && $channel->other_subscriber->user ? $channel->other_subscriber->user->name : 'Unknown' }} </span>
                <span class="text-primary text-14 last-message">
                    @if ($channel->last_message && $channel->last_message->user_id == $my_user_id)
                        You: {{ $channel->last_message->message }}
                    @elseif($channel->last_message)
                        {{ $channel->last_message->message }}
                    @else
                        No message yet.
                    @endif
                </span>

            </div>
        </div>
        <div>
            <div class="d-flex flex-column justify-content-between">
                <p class="ms-2 text-gray-500 text-12">{{ date('h:i a', strtotime(optional($channel->last_message)->created_at))}}</p>
            </div>
            <div class="d-flex justify-content-end">
            </div>
        </div>
    </a>
@endforeach
