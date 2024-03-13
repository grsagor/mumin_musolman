<h5>Messages</h5>
<div class="mb-3 position-relative">
    <label for="search"
        class="form-label m-0 position-absolute top-0 bottom-0 start-0 end-0 d-flex align-items-center ps-3"><span
            class="input__with__icon--icon_container d-flex flex-column align-items-center justify-content-center"><i
                class="fa-solid fa-magnifying-glass"></i></span><span class="ms-1">Search</span></label>
    <input id="search" type="text" class="form-control rounded-pill input__with__icon" onchange="reloadChannelsContainer(this.value);" name="search">
</div>

<div id="channels_container">
    @include('backend.pages.message.message-users')
</div>
