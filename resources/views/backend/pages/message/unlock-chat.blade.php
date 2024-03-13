<div class="h-100 d-flex flex-column justify-content-center align-items-center">
    <div class="unlock-page-img-container aspect-ratio-1x1 position-relative">
        <div>
            <img class="rounded-circle object-fit-cover" height="100px" width="100px" src="{{ $current_channel->other_subscriber->user->profile_image ? asset('uploads/user-images/' . $current_channel->other_subscriber->user->profile_image) : asset('assets/img/no-img-cover.jpg') }}" alt="">
        </div>
        <div
            class="active-dot-container aspect-ratio-1x1 overflow-hidden d-flex flex-column align-items-center justify-content-center position-absolute rounded-circle bg-white">
            <i class="fa-solid fa-circle text-22 text-success-500"></i>
        </div>
    </div>
    <h3 class="text-gray-800 fw-medium">Want to chat with me ?</h3>
    <p class="text-gray-800 mb-3">Unlock chat with all the features by purchasing</p>
    <button class="btn btn-primary chat_unlock_modal_open_btn">Unlock</button>
</div>


<div class="modal fade" id="chatUnlockModal" tabindex="-1" aria-labelledby="chatUnlockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="chatSubscribeModalForm" action="{{ route('frontend.chat.subscribe') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="creator" value="{{ $current_channel->other_subscriber->user->id }}">
                <input type="hidden" name="plan" value="Paid">
                <div class="modal-header border-0">
                    <h1 class="modal-title fs-5" id="chatUnlockModalLabel">Chat Unlock</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body chat_form">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="server_side_error" role="alert">

                            </div>
                        </div>
                        <div class="col-sm-12 tab-content" id="v-pills-tabContent">
                            <div class="">
                                <div class="input-group mb-1">
                                    <div class="flex-fill">
                                        <input type="radio" class="btn-check" name="subscribe_plan" data-price="{{$current_channel->other_subscriber->user->chat_per_hour_price ?? 0 }}" value="{{$current_channel->other_subscriber->user->chat_hour ?? 0 }} hours subscription" id="30-days-outlined" autocomplete="off" required >
                                        <label class="btn btn-outline-primary w-100 rounded-0 rounded-start text-start" for="30-days-outlined">{{$current_channel->other_subscriber->user->chat_hour ?? 0 }} hours subscription</label>
                                    </div>
                                    <span class="input-group-text border-primary"><i class="fa-solid fa-dollar-sign"></i> {{ $current_channel->other_subscriber->user->chat_per_hour_price ?? 0}}</span>
                                </div>
                            </div>

                            <label for="deposit_card-1" class="border border-secondary text-primary rounded d-flex align-items-baseline gap-2 p-3">
                                <input type="radio" name="choose_card" value="Wallet Credit" id="deposit_card-1" required>
                                <div class="d-flex flex-1 justify-content-between">
                                    <div>
                                        <p class="text-gray-900 m-0">${{ optional(Auth::user()->wallet)->balance ?? 0 }}</p>
                                        <div class="d-flex align-items-center">
                                            <span class="text-gray-600">Wallet Credit</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <a href="{{ route('frontend.settings.wallet') }}" class="btn btn-primary text-primary">Add Credit</a>
                                    </div>
                                </div>
                            </label>

                            <p class="text-gray-500 fw-semibold">Choose Card</p>

                            @forelse (optional(Auth::user())->accounts as $account)
                                <label for="choose-visa{{$account->id}}" class="mb-1 border bg-orange-25 border-secondary text-primary rounded d-flex align-items-baseline gap-2 p-2">
                                    <input type="radio" name="choose_card" value="{{ $account->account_no }}" id="choose-visa{{$account->id}}">
                                    <div class="d-flex flex-1 justify-content-between">
                                        <div class="d-flex flex-column justify-content-center">
                                            <p class="text-gray-900 m-0">{{ str_repeat('*', 7) . substr($account->account_no, -4) }}</p>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <div class="bg-orange-100 p-2 rounded">
                                                @if ($account->type == 'Visa')
                                                    <img src="{{ asset('assets/img/ui/visa.png') }}"  class="w-100" height="24px" alt="">
                                                @elseif ($account->type == 'American')
                                                    <img src="{{ asset('assets/img/ui/american.png') }}" class="w-100" height="24px" alt="">
                                                @elseif ($account->type == 'Mastercard')
                                                    <img src="{{ asset('assets/img/ui/mastercard.png') }}" class="w-100" height="24px" alt="">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            @empty
                                <p>No accounts found!</p>
                            @endforelse
                            <a href="{{ route('frontend.settings.banking') }}" class="btn btn-outline-primary w-100 mt-2 p-3"><i class="fa-solid fa-plus"></i> New</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="rounded-pill text-gray-700 fw-medium flex-1 bg-transparent border-gray-300 btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="chatSubscribeBtn" data-check-area="chat_form" class="rounded-pill flex-1 btn btn-primary flex-1 fw-medium">Subscribe</button>
                </div>
            </form>
        </div>
    </div>
</div>
