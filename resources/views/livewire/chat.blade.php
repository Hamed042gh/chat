<div class="flex flex-col h-screen p-6">
    <!-- عنوان چت با آیکون و مرکز چینش -->
    <div class="bg-blue-500 text-white flex items-center justify-center p-4 rounded-t-lg shadow-lg mb-6">
        <i class="fas fa-comments text-2xl mr-3"></i>
        <h1 class="text-2xl font-bold">Chat Room</h1>
    </div>

    <div class="flex flex-grow" wire:poll.1000ms>
        
        <div class="w-3/4 p-6 bg-white rounded-lg shadow-lg flex flex-col">
            <div class="flex-1 mb-4 overflow-auto h-96 border border-gray-200 rounded-lg"  id="messages">
                @foreach ($messages as $message)
                    @if ($message && isset($message->body) && isset($message->user))
                        <div class="mb-2 p-3 border-b border-gray-300 bg-gray-50 rounded-md">
                            <strong class="text-gray-800">{{ $message->user }}</strong>: {{ $message->body }}
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- فرم ارسال پیام -->
            <div class="flex flex-col space-y-4">
                <textarea wire:model="newMessage" wire:keydown.enter="handleMessageSubmission" placeholder="Type your message..."
                    class="w-full p-3 border border-gray-300 rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300" rows="4"></textarea>
                <button type="submit" wire:click="handleMessageSubmission"
                    class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                    Send
                </button>
            </div>
        </div>
    </div>
</div>
