<div
    class="flex my-[10.5rem] justify-center items-center"
    x-data="drop_file_component()">
    <div
        class="py-6 w-96 rounded flex flex-col justify-center items-center"
        x-bind:class="dropingFile ? 'bg-white border-gray-200' : 'border-gray-400 bg-white'"
        x-on:drop="dropingFile = false"
        x-on:drop.prevent="
                handleFileDrop($event)
            "
        x-on:dragover.prevent="dropingFile = true"
        x-on:dragleave.prevent="dropingFile = false">

        <div id="zdrop" class="fileuploader">
            <div id="upload-label" style="width: 200px;">
                <span class="title">Drop .stl or .obj files here</span>
                <span> Max size : 512MB </span>
            </div>
        </div>

        <div class="text-center" wire:loading.remove wire.target="newFiles"></div>
        <div class="mt-1 col-2" wire:loading.flex wire.target="newFiles">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-700"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <div>Loading content...</div>
        </div>
    </div>
</div>

<script>
    function drop_file_component() {
        return {
            dropingFile: false,
            handleFileDrop(e) {
                if (event.dataTransfer.files.length > 0) {
                    const files = e.dataTransfer.files;
                @this.uploadMultiple('newFiles', files,
                    (uploadedFilename) => {
                    }, () => {
                    }, (event) => {
                    }
                )
                }
            }
        };
    }
</script>
