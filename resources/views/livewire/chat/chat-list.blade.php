{{-- resources/views/livewire/chat/chat-list.blade.php --}}

<div class="flex flex-col h-full bg-white" wire:key="chatlist">

    {{-- ═══════════════════════════════════════════════════════════
         HEADER INBOX
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="px-5 py-4 border-b border-gray-100 flex-shrink-0">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-gray-800 text-lg">Pesan</h2>
                <p class="text-xs text-gray-400 mt-0.5">
                    {{ count($conversations) }} percakapan
                </p>
            </div>

            {{-- Badge total unread --}}
            @if($totalUnread > 0)
            <span class="bg-blue-600 text-white text-xs font-bold px-2.5 py-1 rounded-full min-w-[24px] text-center">
                {{ $totalUnread > 99 ? '99+' : $totalUnread }}
            </span>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         DAFTAR CONVERSATION
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="flex-1 overflow-y-auto">

        @forelse($conversations as $conv)
        <button
            wire:click="selectConversation({{ $conv['id'] }})"
            wire:key="conv-{{ $conv['id'] }}"
            class="w-full text-left px-5 py-4 hover:bg-gray-50 transition-colors border-b border-gray-50 relative
                   {{ $conv['is_active'] ? 'bg-blue-50 border-l-4 border-l-blue-600' : 'border-l-4 border-l-transparent' }}"
        >
            <div class="flex items-start gap-3">

                {{-- Avatar --}}
                <div class="relative flex-shrink-0">
                    <div class="w-11 h-11 rounded-full flex items-center justify-center font-bold text-sm
                                {{ ($conv['other_user']['role'] ?? '') === 'customer'
                                   ? 'bg-blue-100 text-blue-700'
                                   : (($conv['other_user']['role'] ?? '') === 'kurir'
                                       ? 'bg-amber-100 text-amber-700'
                                       : 'bg-purple-100 text-purple-700') }}">
                        {{ strtoupper(substr($conv['other_user']['name'] ?? '?', 0, 1)) }}
                    </div>

                    {{-- Indikator role --}}
                    <span class="absolute -bottom-0.5 -right-0.5 w-4 h-4 rounded-full border-2 border-white text-xs flex items-center justify-center
                                 {{ ($conv['other_user']['role'] ?? '') === 'customer' ? 'bg-blue-500' :
                                    (($conv['other_user']['role'] ?? '') === 'kurir' ? 'bg-amber-500' : 'bg-purple-500') }}">
                    </span>
                </div>

                {{-- Konten --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <p class="font-semibold text-gray-800 text-sm truncate
                                  {{ $conv['unread_count'] > 0 ? 'font-bold' : '' }}">
                            {{ $conv['other_user']['name'] ?? 'Unknown' }}
                        </p>
                        <span class="text-xs text-gray-400 flex-shrink-0">
                            {{ $conv['time_label'] }}
                        </span>
                    </div>

                    {{-- Konteks order (jika ada) --}}
                    @if($conv['order_code'])
                    <span class="inline-flex items-center gap-1 text-xs text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded mb-0.5">
                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Order #{{ $conv['order_code'] }}
                    </span>
                    @endif

                    {{-- Preview pesan terakhir --}}
                    <div class="flex items-center justify-between gap-2">
                        <p class="text-xs text-gray-500 truncate leading-relaxed
                                  {{ $conv['unread_count'] > 0 ? 'text-gray-700 font-medium' : '' }}">
                            @if($conv['last_sender_id'] === auth()->id())
                                <span class="text-gray-400">Kamu: </span>
                            @endif
                            {{ $conv['last_message'] }}
                        </p>

                        {{-- Badge unread --}}
                        @if($conv['unread_count'] > 0)
                        <span class="flex-shrink-0 bg-blue-600 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                            {{ $conv['unread_count'] > 9 ? '9+' : $conv['unread_count'] }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </button>
        @empty

        {{-- State kosong --}}
        <div class="flex flex-col items-center justify-center h-64 text-center px-6">
            <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center mb-3">
                <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                </svg>
            </div>
            <p class="font-semibold text-gray-500 text-sm">Belum ada percakapan</p>
            <p class="text-xs text-gray-400 mt-1 leading-relaxed">
                Chat akan muncul di sini saat customer atau admin memulai percakapan.
            </p>
        </div>

        @endforelse
    </div>
</div>

{{-- ── JavaScript: Echo untuk update inbox real-time ─────────────── --}}
<script>
(function() {
    const currentUserId = @json(auth()->id());

    if (typeof window.Echo === 'undefined') return;

    // Subscribe ke channel inbox personal user ini
    // Setiap user punya channel sendiri: user-inbox.{userId}
    window.Echo
        .private(`user-inbox.${currentUserId}`)
        .listen('.ConversationUpdated', (data) => {

            // Kirim ke Livewire untuk update list conversation
            Livewire.dispatch('inbox-updated', data);

            // Update badge di navbar (jika ada elemen navbar badge)
            updateNavbarBadge();

            // Browser notification untuk inbox update
            // (hanya jika tab tidak aktif)
            if (document.hidden) {
                showInboxNotification(data);
            }
        });

    // ── Update badge navbar ──────────────────────────────────────
    function updateNavbarBadge() {
        // Livewire akan dispatch 'update-unread-badge' dengan total count baru
        document.addEventListener('livewire:dispatch', (e) => {
            if (e.detail?.name === 'update-unread-badge') {
                const count = e.detail?.params?.count ?? 0;
                const badge = document.getElementById('navbar-chat-badge');
                if (!badge) return;
                if (count > 0) {
                    badge.textContent = count > 99 ? '99+' : count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }
        });
    }

    // ── Browser Notification untuk inbox ────────────────────────
    async function showInboxNotification(data) {
        if (!('Notification' in window)) return;
        if (Notification.permission !== 'granted') return;

        const senderName  = data.other_user?.name ?? 'Pesan baru';
        const lastMessage = data.last_message ?? '';
        const orderCode   = data.order_code ? ` · Order #${data.order_code}` : '';

        const notif = new Notification(`💬 ${senderName}${orderCode}`, {
            body:    lastMessage.length > 100 ? lastMessage.substring(0, 100) + '...' : lastMessage,
            icon:    '/favicon.ico',
            tag:     `inbox-${data.conversation_id}`,
            renotify: true,
        });

        notif.onclick = () => {
            window.focus();
            // Pilih conversation yang diklik
            Livewire.dispatch('select-conversation', { conversationId: data.conversation_id });
            notif.close();
        };

        setTimeout(() => notif.close(), 5000);
    }

    updateNavbarBadge();
})();
</script>