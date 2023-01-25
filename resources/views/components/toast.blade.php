@props(['color' => [
    'success' => 'text-green-800 bg-green-300',
    'fail' => 'text-red-700 bg-red-300',
    'warning' => 'text-orange-700 bg-orange-300',
], 'type' => 'success', 'message' => ''])

<div class="{{ $message ? '' : 'hidden' }} px-4 py-2 rounded fixed top-2 right-2 z-30 inline-block max-w-md {{ $color[$type] }}" id="toast">
    <div class="flex space-x-5 items-start">
        <div>
            {{ $message }}
        </div>
        <button id="closeToast" type="button">
            X
        </button>
    </div>
</div>