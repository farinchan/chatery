 <div class="row justify-content-center">
     <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-5">
         <div class="card bg-white border-0 rounded-3 mb-4">
             <div class="card-body p-4">
                 <div class="mb-4">
                     <h4 class="fw-medium fs-16 mb-0 mb-3">Messages</h4>
                     <form class="position-relative default-src-form">
                         <input type="text" class="form-control rounded-1" placeholder="Search here">
                         <i
                             class="material-symbols-outlined position-absolute top-50 start-0 translate-middle-y fs-18">search</i>
                     </form>
                 </div>

                 <ul class="nav nav-tabs justify-content-between chat-tabs mb-4" id="myTab" role="tablist">
                     <li class="nav-item" role="presentation">
                         <button class="nav-link p-0 border-0 fw-medium text-body rounded-0 pb-2 active"
                             id="all-message-tab" data-bs-toggle="tab" data-bs-target="#all-message-tab-pane"
                             type="button" role="tab" aria-controls="all-message-tab-pane" aria-selected="true">All
                             Message</button>
                     </li>

                     <li class="nav-item" role="presentation">
                         <button class="nav-link p-0 border-0 fw-medium text-body rounded-0 pb-2" id="contacts-tab"
                             data-bs-toggle="tab" data-bs-target="#contacts-tab-pane" type="button" role="tab"
                             aria-controls="contacts-tab-pane" aria-selected="false">Contacts</button>
                     </li>
                 </ul>

                 <div class="tab-content" id="myTabContent">
                     <div class="tab-pane fade show active" id="all-message-tab-pane" role="tabpanel"
                         aria-labelledby="all-message-tab" tabindex="0">
                         <div class="max-h-497" style="overflow-y: auto;">

                             <ul class="ps-0 mb-0 list-unstyled chat-list">
                                 @foreach ($ui as $u)
                                     <li wire:click="getChatMessages('{{ $u['id'] }}', '{{ $u['name'] }}', '{{ $u['picture'] }}')"
                                         class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                         <div class="d-flex align-items-center">
                                             <div class="flex-shrink-0 position-relative">
                                                 <img src="{{ $u['picture'] ? $u['picture'] : 'https://ui-avatars.com/api/?background=random&name=' . urlencode($u['name']) }}"
                                                     class="wh-45 rounded-circle" alt="user">
                                                 <div
                                                     class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2">
                                                 </div>
                                             </div>
                                             <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                 <h4 class="fs-16 fw-semibold mb-1">
                                                     {{ $u['name'] }}</h4>
                                                 <span class="d-inline-block text-truncate"
                                                     style="max-width: 150px;">{{ $u['lastMessage']['body'] }}</span>
                                             </div>
                                         </div>
                                         <div class="text-end">
                                             @php
                                                 $ts = $u['lastMessage']['timestamp'] ?? null;
                                                 if ($ts) {
                                                     $time =
                                                         is_numeric($ts) && strlen((string) $ts) > 10
                                                             ? \Carbon\Carbon::createFromTimestampMs($ts)
                                                             : \Carbon\Carbon::createFromTimestamp($ts);
                                                 } else {
                                                     $time = null;
                                                 }
                                             @endphp
                                             <span
                                                 class="d-block fs-12">{{ $time ? $time->diffForHumans() : '—' }}</span>
                                         </div>
                                     </li>
                                 @endforeach

                             </ul>
                         </div>
                     </div>
                     <div class="tab-pane fade" id="contacts-tab-pane" role="tabpanel" aria-labelledby="contacts-tab"
                         tabindex="0">
                         <div class="max-h-497" style="overflow-y: auto; ">

                             <ul class="ps-0 mb-4 list-unstyled chat-list">
                                 @foreach ($contacts as $contact)
                                     @if ($contact['isMyContact'])
                                         <li
                                             class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 cursor">
                                             <div class="d-flex align-items-center">
                                                 <div class="flex-shrink-0 position-relative">
                                                     <img src="{{ 'https://ui-avatars.com/api/?background=random&name=' . urlencode($contact['name']) }}"
                                                         class="wh-45 rounded-circle" alt="user">
                                                     <div
                                                         class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2">
                                                     </div>
                                                 </div>
                                                 <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                                     <h4 class="fs-16 fw-semibold mb-1">
                                                         {{ $contact['name'] }}</h4>
                                                     <span class="d-inline-block text-truncate text-danger"
                                                         style="max-width: 150px;">{{ $contact['number'] }}</span>
                                                 </div>
                                             </div>
                                             <div class="text-end">
                                                 <span class="d-block fs-12 mb-1">Just Now</span>
                                                 <div class="d-flex gap-1 justify-content-between">
                                                     <i
                                                         class="ri-phone-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                     <i
                                                         class="ri-vidicon-fill fs-14 text-primary wh-25 lh-25 bg-primary rounded-1 bg-opacity-10 text-center hover-bg"></i>
                                                 </div>
                                             </div>
                                         </li>
                                     @endif
                                 @endforeach
                             </ul>

                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="col-xxl-8 col-xl-7 col-lg-7 col-md-7">
         <div class="card bg-white border-0 rounded-3 mb-4">
             @if ($messages && count($messages) > 0)
                 <div class="card-body p-4">
                     <div
                         class="d-flex justify-content-between align-items-center flex-wrap ga-2 border-bottom pb-4 mb-4">
                         <div class="d-flex align-items-center">
                             <div class="flex-shrink-0 position-relative">
                                 <img src="{{ $selectedChatPicture ? $selectedChatPicture : 'https://ui-avatars.com/api/?background=random&name=' . urlencode($selectedChatName) }}" class="wh-52 rounded-circle" alt="user">
                                 <div
                                     class="position-absolute p-1 bg-success border border-2 border-white rounded-circle status-position2">
                                 </div>
                             </div>
                             <div class="flex-grow-1 ms-2 ps-1 position-relative top-2">
                                 <h4 class="fs-16 fw-semibold mb-1">{{ $selectedChatName }}</h4>
                                 {{-- <span>Active now</span> --}}
                             </div>
                         </div>
                         <ul class="ps-0 mb-0 list-unstyled chat-call-option d-flex gap-1 gap-xl-3">
                             <li>
                                 <button class="p-0 border-0 bg-transparent" data-bs-toggle="tooltip"
                                     data-bs-placement="top" data-bs-title="Audio Call">
                                     <i class="ri-phone-line fs-16 text-body hover"></i>
                                 </button>
                             </li>
                             <li>
                                 <button class="p-0 border-0 bg-transparent" data-bs-toggle="tooltip"
                                     data-bs-placement="top" data-bs-title="Video Call">
                                     <i class="ri-vidicon-fill fs-16 text-body hover"></i>
                                 </button>
                             </li>
                             <li>
                                 <div class="dropdown action-opt" data-bs-toggle="tooltip" data-bs-placement="top"
                                     data-bs-title="More Option">
                                     <button class="p-0 border-0 bg-transparent" type="button"
                                         data-bs-toggle="dropdown" aria-expanded="false">
                                         <i class="ri-more-2-fill fs-16 text-body hover"></i>
                                     </button>
                                     <ul class="dropdown-menu dropdown-menu-end bg-white border box-shadow">
                                         <li>
                                             <a class="dropdown-item" href="my-profile.html">
                                                 <i data-feather="eye"></i>
                                                 View Profile
                                             </a>
                                         </li>
                                         <li>
                                             <a class="dropdown-item" href="javascript:;">
                                                 <i data-feather="trash-2"></i>
                                                 Delete Chat
                                             </a>
                                         </li>
                                         <li>
                                             <a class="dropdown-item" href="javascript:;">
                                                 <i data-feather="lock"></i>
                                                 Block
                                             </a>
                                         </li>
                                     </ul>
                                 </div>
                             </li>
                         </ul>
                     </div>


                     <ul class="mb-0 list-unstyled chat-details max-h-497" style="overflow-y: auto;">
                         @foreach ($messages as $message)
                             @if ($message['fromMe'])
                                 <li class="mb-4 ms-auto own-chat">
                                     <div class="d-sm-flex text-end">
                                         <div class="flex-grow-1 mb-3 mb-sm-0">
                                             <div class="d-flex align-items-center justify-content-end">
                                                 <div class="dropdown action-opt me-2">
                                                     <button class="p-0 border-0 bg-transparent" type="button"
                                                         data-bs-toggle="dropdown" aria-expanded="false">
                                                         <i class="ri-more-2-fill text-secondary"></i>
                                                     </button>
                                                     <ul
                                                         class="dropdown-menu dropdown-menu-end bg-white border box-shadow">

                                                         <li>
                                                             <a class="dropdown-item" href="javascript:;">
                                                                 <i data-feather="trash-2"></i>
                                                                 Delete You
                                                             </a>
                                                         </li>
                                                         <li>
                                                             <a class="dropdown-item" href="javascript:;">
                                                                 <i data-feather="trash-2"></i>
                                                                 Delete Everyone
                                                             </a>
                                                         </li>
                                                     </ul>
                                                 </div>

                                                 <p>{!! nl2br(e($message['body'])) !!}</p>
                                             </div>
                                             @php
                                                 $ts = $message['timestamp'] ?? null;
                                                 if ($ts) {
                                                     $time =
                                                         is_numeric($ts) && strlen((string) $ts) > 10
                                                             ? \Carbon\Carbon::createFromTimestampMs($ts)
                                                             : \Carbon\Carbon::createFromTimestamp($ts);
                                                 } else {
                                                     $time = null;
                                                 }
                                             @endphp
                                             <span
                                                 class="fs-12 d-block">{{ $time ? $time->diffForHumans() : '—' }}</span>
                                         </div>
                                     </div>
                                 </li>
                             @else
                                 <li class="mb-4">
                                     <div class="d-sm-flex">
                                         <div class="flex-shrink-0">
                                             <img src="{{ $selectedChatPicture ? $selectedChatPicture : 'https://ui-avatars.com/api/?background=random&name=' . urlencode($selectedChatName) }}" class="wh-48 rounded-circle"
                                                 alt="user">
                                         </div>
                                         <div class="flex-grow-1 ms-sm-3 mt-3 mt-sm-0">
                                             <div class="d-flex align-items-center">
                                                 <p>{!! nl2br(e($message['body'])) !!}</p>

                                                 <div class="dropdown action-opt ms-2">
                                                     <button class="p-0 border-0 bg-transparent" type="button"
                                                         data-bs-toggle="dropdown" aria-expanded="false">
                                                         <i class="ri-more-2-fill text-secondary"></i>
                                                     </button>
                                                     <ul
                                                         class="dropdown-menu dropdown-menu-end bg-white border box-shadow">

                                                         <li>
                                                             <a class="dropdown-item" href="javascript:;">
                                                                 <i data-feather="trash-2"></i>
                                                                 Delete You
                                                             </a>
                                                         </li>
                                                         <li>
                                                             <a class="dropdown-item" href="javascript:;">
                                                                 <i data-feather="trash-2"></i>
                                                                 Delete Everyone
                                                             </a>
                                                         </li>
                                                     </ul>
                                                 </div>
                                             </div>
                                             @php
                                                 $ts = $message['timestamp'] ?? null;
                                                 if ($ts) {
                                                     $time =
                                                         is_numeric($ts) && strlen((string) $ts) > 10
                                                             ? \Carbon\Carbon::createFromTimestampMs($ts)
                                                             : \Carbon\Carbon::createFromTimestamp($ts);
                                                 } else {
                                                     $time = null;
                                                 }
                                             @endphp
                                             <span
                                                 class="fs-12 d-block">{{ $time ? $time->diffForHumans() : '—' }}</span>
                                         </div>
                                     </div>
                                 </li>
                             @endif
                         @endforeach

                     </ul>

                     <div
                         class="d-sm-flex justify-content-between align-items-center bg-gary-light for-dark rounded-3 p-4">
                         <div class="d-flex gap-3 justify-content-center justify-content-sm-start">
                             <button class="p-0 border-0 bg-transparent" data-bs-toggle="tooltip"
                                 data-bs-placement="top" data-bs-title="Emoji">
                                 <i class="ri-emotion-laugh-line fs-18 text-body"></i>
                             </button>
                             <button class="p-0 border-0 bg-transparent" data-bs-toggle="tooltip"
                                 data-bs-placement="top" data-bs-title="Link">
                                 <i class="ri-link-m fs-18 text-body"></i>
                             </button>
                             <button class="p-0 border-0 bg-transparent" data-bs-toggle="tooltip"
                                 data-bs-placement="top" data-bs-title="Voice">
                                 <i class="ri-mic-line fs-18 text-body"></i>
                             </button>
                             <button class="p-0 border-0 bg-transparent" data-bs-toggle="tooltip"
                                 data-bs-placement="top" data-bs-title="Image">
                                 <i class="ri-image-line fs-18 text-body"></i>
                             </button>
                         </div>
                         <form action="" class="w-100 ps-sm-4 ps-xxl-4 ms-xxl-3 mt-3 mt-sm-0 position-relative">
                             <input type="text" class="form-control rounded-1 border-0 text-dark h-55"
                                 placeholder="Type your message">
                             <button
                                 class="p-0 border-0 bg-transparent position-absolute top-50 end-0 translate-middle-y pe-3 d-sm-none">
                                 <i class="material-symbols-outlined fs-24 text-primary">send</i>
                             </button>
                         </form>
                         <button class="p-0 border-0 bg-primary d-none d-sm-block rounded-1 ms-3">
                             <i class="material-symbols-outlined fs-24 text-white wh-55 lh-55 d-inline-block">send</i>
                         </button>
                     </div>
                 </div>
             @else
                 <div class="card-body p-4">
                     <div class="d-flex justify-content-center align-items-center flex-column ga-2 min-h-400">
                         <i class="ri-chat-1-line fs-48 text-secondary mb-3"></i>
                         <h4 class="fs-20 fw-semibold mb-2">Select a chat to start messaging</h4>
                         <p class="mb-0 text-center">Your messages will appear here. Select a chat from the left to
                             view
                             messages.</p>
                     </div>
                 </div>
             @endif
         </div>
     </div>
 </div>


 @push('scripts')
     <script>
         document.addEventListener('DOMContentLoaded', function() {
             // Function to scroll chat to bottom
             function scrollChatToBottom() {
                 const chatDetails = document.querySelector('.chat-details');
                 if (chatDetails) {
                     chatDetails.scrollTop = chatDetails.scrollHeight;
                 }
             }

             // Scroll on page load
             scrollChatToBottom();

             // Scroll when new messages are loaded (Livewire)
             document.addEventListener('livewire:load', function() {
                 Livewire.hook('message.processed', (message, component) => {
                     scrollChatToBottom();
                 });
             });

             // For Livewire v3
             document.addEventListener('livewire:initialized', () => {
                 Livewire.hook('morph.updated', () => {
                     scrollChatToBottom();
                 });
             });
         });
     </script>
 @endpush
