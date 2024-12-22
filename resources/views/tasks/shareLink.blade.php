<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Share Task Link') }}
                <a href="{{ route('tasks.index') }}" style="float: right">
                    <h2>Back to Tasks</h2>
                </a>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="form-container">
                        <h1 class="form-title">Public Link Generated</h1>

                        <p class="text-gray-300 mb-4">The link to share this task has been successfully created. You can use the link below to share the task with others. Please note the link will expire at the specified time.</p>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="shareable-link" class="form-label">Shareable Link</label>
                                <input type="text" id="shareable-link" class="form-input" value="{{ $link }}" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="expires-at" class="form-label">Expires At</label>
                                <input type="text" id="expires-at" class="form-input" value="{{ $expires_at }}" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <button class="form-button" onclick="copyToClipboard()">Copy Link</button>
                            <a href="{{ route('tasks.index') }}" class="form-button">Back to Tasks</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const linkField = document.getElementById('shareable-link');
            linkField.select();
            linkField.setSelectionRange(0, 99999); // For mobile devices
            navigator.clipboard.writeText(linkField.value).then(() => {
                alert('Link copied to clipboard!');
            }).catch(err => {
                alert('Failed to copy the link. Please try again.');
            });
        }
    </script>
</x-app-layout>
