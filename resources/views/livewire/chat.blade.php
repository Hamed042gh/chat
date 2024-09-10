<div class="flex" wire:poll.1000ms>
    <div class="w-1/4 p-4 bg-gray-100 rounded-lg shadow-md mr-4">
        <h3 class="text-xl font-semibold mb-4">Online Users</h3>

        <ul id="online-users" class="list-disc list-inside bg-white p-4 rounded-lg shadow-sm">
            @foreach ($onlineUsers as $user)
                <li class="text-gray-1000">{{ $user->name }}</li>
            @endforeach
        </ul>
    </div>

    <div class="w-3/4 p-4 bg-white rounded-lg shadow-md">
        <div class="mb-4 overflow-auto h-96">
            @foreach ($messages as $message)
                @if ($message && isset($message->body) && isset($message->user))
                    <div class="mb-2 p-2 border-b border-gray-200">
                        <strong class="text-gray-800">{{ $message->user }}</strong>: {{ $message->body }}
                    </div>
                @endif
            @endforeach
        </div>

        <div>
            <form wire:submit.prevent="handleMessageSubmission" class="flex flex-col space-y-4">
                <textarea wire:model="newMessage" wire:keydown.enter="handleMessageSubmission" placeholder="Type your message..."
                    class="w-full p-2 border border-gray-300 rounded-lg resize-none" rows="4"></textarea>
                <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Send
                </button>
            </form>
        </div>
    </div>
</div>
