@extends('layouts.app')
@section('title', 'Pesan')
@section('page-title', 'Pesan')

@section('content')

{{-- Container dua panel --}}
<div
    class="flex h-[calc(100vh-4rem)] overflow-hidden rounded-2xl border border-gray-100 shadow-sm bg-white"
    x-data="{ activeConversation: @json($activeConversationId ?? null) }"
    @conversation-selected.window="activeConversation = $event.detail.conversationId">

    {{-- ══════════════════════════════════════════════════════════
         PANEL KIRI — Daftar conversation (ChatList)
    ══════════════════════════════════════════════════════════ --}}
    <div
        class="flex-shrink-0 border-r border-gray-100 overflow-hidden"
        :class="activeConversation ? 'hidden md:flex md:w-72 lg:w-80' : 'flex w-full md:w-72 lg:w-80'"
        style="flex-direction: column;">
        @livewire('chat.chat-list', ['activeConversationId' => $activeConversationId ?? null])
    </div>

    {{-- ══════════════════════════════════════════════════════════
         PANEL KANAN — Chat box (berubah sesuai conversation dipilih)
    ══════════════════════════════════════════════════════════════ --}}
    <div
        class="flex-1 overflow-hidden"
        :class="activeConversation ? 'flex flex-col' : 'hidden md:flex md:flex-col'">

        {{-- State: belum pilih conversation (desktop) --}}
        <template x-if="!activeConversation">
            <div class="flex flex-col items-center justify-center h-full text-center px-8">
                <div class="w-20 h-20 bg-blue-50 rounded-3xl flex items-center justify-center mb-5">
                    <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <h3 class="font-bold text-gray-600 text-xl">Pilih percakapan</h3>
                <p class="text-gray-400 text-sm mt-2 leading-relaxed max-w-xs">
                    Pilih percakapan dari daftar di sebelah kiri, atau mulai chat baru dari halaman order.
                </p>
            </div>
        </template>

        {{-- Tampilkan ChatBox saat conversation dipilih --}}
        @if(isset($activeConversationId) && $activeConversationId)
        <div class="flex flex-col h-full" id="chatbox-wrapper">
            {{-- SINTAKS TAG BARU: Mengeliminasi eror spasi gaib / kompilasi string --}}
            @livewire('chat.chat-box', [
            'conversationId' => $activeConversationId
            ], key('chatbox-' . $activeConversationId))
        </div>
        @else
        {{-- Alpine akan tampilkan placeholder sampai conversation dipilih --}}
        <div id="chatbox-placeholder" class="flex-1"></div>
        @endif

    </div>
</div>

<script>
    // Handle ketika user memilih percakapan dari daftar kiri (Diperbaiki untuk Livewire v3)
    window.addEventListener('conversation-selected', (e) => {
        // Ambil ID percakapan baru yang dikirim oleh Livewire v3 component dispatch
        const newId = e.detail?.conversationId || e.detail?.params?.conversationId || e.detail?.[0]?.conversationId;
        if (!newId) return;

        // SOLUSI UTAMA: Lakukan redirect halaman agar halaman merender penuh ChatBox beserta script pendukungnya
        window.location.href = `/chat/${newId}`;
    });

    // Handle tombol back di browser
    window.addEventListener('popstate', (e) => {
        if (e.state?.conversationId) {
            window.location.href = `/chat/${e.state.conversationId}`;
        } else {
            window.location.href = '/chat';
        }
    });
</script>
@endsection