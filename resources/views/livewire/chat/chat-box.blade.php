<div class="flex flex-col h-full bg-white">

    {{-- ═══════════════════════════════════════════════════════════
         HEADER — Info lawan bicara + konteks order
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100 bg-white flex-shrink-0">

        {{-- Avatar lawan bicara --}}
        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0
                    {{ ($otherUser['role'] ?? '') === 'customer' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
            {{ strtoupper(substr($otherUser['name'] ?? '?', 0, 1)) }}
        </div>

        <div class="flex-1 min-w-0">
            {{-- Nama lawan bicara --}}
            <p class="font-bold text-gray-800 text-sm truncate">
                {{ $otherUser['name'] ?? 'User' }}
            </p>
            {{-- Role --}}
            <p class="text-xs text-gray-400 capitalize">{{ $otherUser['role'] ?? '' }}</p>
        </div>

        {{-- Konteks Order --}}
        @if($conversation?->order_id)
        <a href="{{ route('kasir.dashboard', ['search' => $conversation->order->order_code ?? '']) }}"
            class="flex items-center gap-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs px-3 py-1.5 rounded-xl border border-blue-200 transition-colors flex-shrink-0">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span>Order #{{ $conversation->order->order_code ?? '—' }}</span>
        </a>
        @endif
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         AREA PESAN — Scroll container
    ═══════════════════════════════════════════════════════════════ --}}
    <div id="messages-container" class="flex-1 overflow-y-auto px-4 py-5 space-y-1 scroll-smooth" style="scroll-behavior: smooth;">

        @if(empty($messages))
        {{-- State kosong --}}
        <div class="flex flex-col items-center justify-center h-full text-center py-16">
            <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
            </div>
            <p class="font-semibold text-gray-500 text-sm">Belum ada pesan</p>
            <p class="text-xs text-gray-400 mt-1">Mulai percakapan dengan mengirim pesan di bawah.</p>
        </div>
        @else

        @php $prevDate = null; @endphp

        @foreach($messages as $msg)

        {{-- ── Date separator ─────────────────────────────── --}}
        @php
        $msgDate = \Carbon\Carbon::parse($msg['created_at'])->toDateString();
        $showDate = $msgDate !== $prevDate;
        $prevDate = $msgDate;
        @endphp

        @if($showDate)
        <div class="flex items-center gap-3 my-4">
            <div class="flex-1 h-px bg-gray-100"></div>
            <span class="text-xs text-gray-400 bg-white px-2 flex-shrink-0">
                @php
                $d = \Carbon\Carbon::parse($msg['created_at']);
                @endphp
                {{ $d->isToday() ? 'Hari Ini' : ($d->isYesterday() ? 'Kemarin' : $d->isoFormat('D MMMM Y')) }}
            </span>
            <div class="flex-1 h-px bg-gray-100"></div>
        </div>
        @endif

        {{-- ── System Message ──────────────────────────────── --}}
        @if($msg['is_system'])
        <div class="flex justify-center my-2">
            <span class="text-xs bg-gray-100 text-gray-500 px-4 py-1.5 rounded-full flex items-center gap-1.5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ $msg['body'] }}
            </span>
        </div>

        {{-- ── Regular Bubble ──────────────────────────────── --}}
        @else
        <div class="flex {{ $msg['is_mine'] ? 'justify-end' : 'justify-start' }} items-center mb-1 group">
            
            {{-- OPTION MENU --}}
            @if($msg['is_mine'])
            <div class="hidden group-hover:flex items-center gap-1 mx-2 flex-shrink-0 transition-all duration-150">
                @if($msg['type'] !== 'image')
                <button wire:click="startEdit({{ $msg['id'] }})" class="text-gray-400 hover:text-blue-600 p-1 rounded-lg hover:bg-gray-100 transition-colors" title="Edit Pesan">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                </button>
                @endif
                
                <button wire:click="deleteMessage({{ $msg['id'] }})" wire:confirm="Apakah Anda yakin ingin menghapus pesan ini?" class="text-gray-400 hover:text-red-600 p-1 rounded-lg hover:bg-gray-100 transition-colors" title="Hapus Pesan">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
            @endif

            <div class="flex flex-col {{ $msg['is_mine'] ? 'items-end' : 'items-start' }} max-w-[75%]">

                {{-- Nama pengirim --}}
                @if(!$msg['is_mine'])
                <span class="text-xs text-gray-400 ml-1 mb-1">{{ $msg['sender_name'] }}</span>
                @endif

                {{-- Bubble --}}
                <div class="relative rounded-2xl px-4 py-2.5 shadow-sm
                            {{ $msg['is_mine'] ? 'bg-blue-600 text-white rounded-br-sm' : 'bg-gray-100 text-gray-800 rounded-bl-sm' }}">

                    {{-- Attachment Image --}}
                    @if($msg['type'] === 'image' && $msg['attachment_path'])
                    <img src="{{ asset('storage/' . $msg['attachment_path']) }}"
                        alt="Chat Image"
                        class="w-48 h-auto rounded-lg cursor-pointer hover:opacity-90 transition duration-200 mb-1"
                        onclick="openImageModal(this.src)">
                    @endif

                    {{-- Teks --}}
                    @if($msg['type'] !== 'image' || $msg['body'] !== '📷')
                    <p class="text-sm leading-relaxed whitespace-pre-wrap break-words">{{ $msg['body'] }}</p>
                    @endif

                    {{-- Timestamp + Read status --}}
                    <div class="flex items-center gap-1.5 mt-1 {{ $msg['is_mine'] ? 'justify-end' : 'justify-start' }}">
                        <span class="text-xs {{ $msg['is_mine'] ? 'text-blue-200' : 'text-gray-400' }}">
                            {{ $msg['time_label'] }}
                        </span>

                        {{-- Read indicator --}}
                        @if($msg['is_mine'])
                            @if($msg['read_at'])
                            <svg class="w-4 h-4 text-blue-200" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M1.5 12.5l5 5L18 5.5M6.5 12.5l5 5L23 5.5" />
                                <path d="M1 12l5.5 5.5M6.5 12l5.5 5.5M18 6l-9 9" />
                            </svg>
                            @else
                            <svg class="w-3.5 h-3.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        @endforeach
        @endif

        {{-- Anchor untuk scroll to bottom --}}
        <div id="messages-bottom"></div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         INPUT AREA — Form kirim pesan
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="border-t border-gray-100 px-4 py-3 bg-white flex-shrink-0">

        {{-- BAR INDIKATOR EDITING --}}
        @if($editingMessageId)
        <div class="mb-2 flex items-center justify-between bg-amber-50 border border-amber-200 rounded-xl px-3 py-1.5">
            <div class="flex items-center gap-2 text-xs text-amber-800">
                <svg class="w-3.5 h-3.5 text-amber-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                <span>Mengedit pesan...</span>
            </div>
            <button type="button" wire:click="cancelEdit" class="text-xs text-red-500 hover:text-red-700 font-semibold transition-colors">
                Batal
            </button>
        </div>
        @endif

        {{-- Preview attachment --}}
        @if($attachment)
        <div class="mb-2 flex items-center gap-2 bg-blue-50 rounded-xl p-2">
            <img src="{{ $attachment->temporaryUrl() }}" class="w-12 h-12 rounded-lg object-cover">
            <span class="text-xs text-blue-700 flex-1">{{ $attachment->getClientOriginalName() }}</span>
            <button type="button" wire:click="$set('attachment', null)" class="text-blue-400 hover:text-red-500 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        @endif

        <div class="flex items-end gap-2">

            {{-- Tombol upload gambar --}}
            <label class="flex-shrink-0 cursor-pointer p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <input type="file" wire:model="attachment" accept="image/*" class="hidden">
            </label>

            {{-- Input teks --}}
            <div class="flex-1 relative">
                <textarea
                    wire:model="newMessage"
                    wire:keydown.enter.prevent="sendMessage"
                    placeholder="Ketik pesan..."
                    rows="1"
                    class="w-full resize-none border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-gray-50 focus:bg-white leading-relaxed"
                    style="min-height: 44px; max-height: 120px;"
                    oninput="this.style.height='auto'; this.style.height=Math.min(this.scrollHeight, 120)+'px'"></textarea>
            </div>

            {{-- Tombol kirim --}}
            <button
                wire:click="sendMessage"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-60"
                class="flex-shrink-0 w-11 h-11 {{ $editingMessageId ? 'bg-amber-500 hover:bg-amber-600' : 'bg-blue-600 hover:bg-blue-700' }} text-white rounded-2xl flex items-center justify-center transition-all shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed active:scale-95">
                
                <svg wire:loading.remove wire:target="sendMessage" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($editingMessageId)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    @endif
                </svg>
                
                <svg wire:loading wire:target="sendMessage" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                </svg>
            </button>
        </div>

        <p class="text-xs text-gray-400 mt-1.5 ml-1">
            Enter untuk kirim · Shift+Enter untuk baris baru
        </p>
    </div>

    {{-- POP-UP MODAL OVERLAY --}}
    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-80 flex items-center justify-center p-4 transition-opacity duration-300">
        <button onclick="closeImageModal()" class="absolute top-5 right-5 text-white text-4xl font-bold hover:text-gray-300 focus:outline-none z-50">
            &times;
        </button>
        <div class="relative max-w-4xl max-h-[85vh] flex justify-center items-center">
            <img id="modalTargetImage" src="" alt="Zoomed Chat Image" class="max-w-full max-h-[85vh] rounded-lg object-contain shadow-2xl">
        </div>
    </div>

    {{-- SCRIPT DI DALAM ROOT --}}
    @script
    <script>
        const conversationId = $wire.get('conversationId') || @json($conversationId);
        const currentUserId = @json(auth()->id());
        const otherUserName = @json($otherUser['name'] ?? 'Pesan baru');

        window.openImageModal = function(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalTargetImage');
            if (modal && modalImg) {
                modalImg.src = imageSrc;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        };

        window.closeImageModal = function() {
            const modal = document.getElementById('imageModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        };

        document.getElementById('imageModal')?.addEventListener('click', function(event) {
            if (event.target === this) {
                window.closeImageModal();
            }
        });

        function scrollToBottom(smooth = true) {
            const container = document.getElementById('messages-container');
            if (!container) return;
            container.scrollTo({
                top: container.scrollHeight,
                behavior: smooth ? 'smooth' : 'instant',
            });
        }

        scrollToBottom(false);

        $wire.on('message-sent', () => {
            setTimeout(() => scrollToBottom(true), 50);
        });

        $wire.on('message-received', () => {
            setTimeout(() => scrollToBottom(true), 50);
        });

        function initChatEcho() {
            if (typeof window.Echo !== 'undefined') {
                window.Echo.leave(`conversation.${conversationId}`);
                window.Echo.private(`conversation.${conversationId}`).listen('.MessageSent', (data) => {
                    const msg = data.message;
                    if (msg.sender_id === currentUserId) return;

                    $wire.dispatch('new-message-received', { data: msg });

                    if (document.hidden || document.visibilityState !== 'visible') {
                        sendBrowserNotification(otherUserName, msg.body);
                    } else {
                        showToast(`${msg.sender_name}: ${msg.body}`);
                    }
                });
            } else {
                setTimeout(initChatEcho, 200);
            }
        }

        initChatEcho();

        async function sendBrowserNotification(senderName, messageBody) {
            if (!('Notification' in window)) return;
            if (Notification.permission === 'default') {
                const result = await Notification.requestPermission();
                if (result !== 'granted') return;
            }
            if (Notification.permission !== 'granted') return;

            const notif = new Notification(`💬 ${senderName}`, {
                body: messageBody.length > 80 ? messageBody.substring(0, 80) + '...' : messageBody,
                icon: '/favicon.ico',
                badge: '/favicon.ico',
                tag: `chat-${conversationId}`,
                renotify: true,
            });

            notif.onclick = () => {
                window.focus();
                notif.close();
            };
            setTimeout(() => notif.close(), 5000);
        }

        function showToast(message) {
            document.querySelectorAll('.chat-toast').forEach(t => t.remove());
            const toast = document.createElement('div');
            toast.className = 'chat-toast fixed bottom-24 left-1/2 -translate-x-1/2 z-50 bg-gray-900 text-white text-sm px-4 py-2.5 rounded-2xl shadow-xl flex items-center gap-2 max-w-sm';
            toast.innerHTML = `
                <svg class="w-4 h-4 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                <span class="truncate">${message}</span>
            `;
            document.body.appendChild(toast);
            toast.style.opacity = '0';
            toast.style.transform = 'translate(-50%, 10px)';
            requestAnimationFrame(() => {
                toast.style.transition = 'opacity 0.2s, transform 0.2s';
                toast.style.opacity = '1';
                toast.style.transform = 'translate(-50%, 0)';
            });
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translate(-50%, 10px)';
                setTimeout(() => toast.remove(), 200);
            }, 3000);
        }

        if ('Notification' in window && Notification.permission === 'default') {
            setTimeout(() => {
                Notification.requestPermission();
            }, 3000);
        }
    </script>
    @endscript
</div>