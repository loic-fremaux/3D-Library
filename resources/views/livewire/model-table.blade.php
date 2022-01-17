<div class="my-5 w-full rounded-lg shadow-lg overflow-hidden flex flex-col md:flex-row">
    <div class="bg-white w-full md:w-4/5 text-left p-6 md:p-4 space-y-2 flex flex-col justify-between">
        <div class="flex flex-row justify-between">
            <h2 class="text-2xl font-semibold text-gray-700 capitalize dark:text-white">{{ $model->name }}</h2>
            <button class="bg-grey hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded inline-flex items-center"
                    wire:click.prevent="download('{{ $model->path }}')">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/>
                </svg>
                <span>Download</span>
            </button>
        </div>

        @if($editing)
            <textarea id="model-description-editing-{{ $model->id }}" wire:model.defer="model.description">
                {{ $model->description }}
            </textarea>
            <button wire:click="setEditing(false)">Cancel</button>
            <button wire:click="saveDescription({{ $model->id }})">Save</button>
        @else
            <p class="text-gray-500 dark:text-gray-300" wire:click.prevent="setEditing(true)">
                {{ $model->description ?? 'Click here to add a description' }}
            </p>
        @endif

        <div>
            @foreach($tags as $tag)
                <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{$tag->name}}</span>
            @endforeach

            @if($newTagName === null)
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded-full" wire:click.prevent="searchTag">Add tag</button>
            @else
                <input class="shadow appearance-none border border-red-500 rounded text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="add-tag-{{ $model->id }}" type="text" wire:model="newTagName" wire:keydown.prevent.enter="addTag">
            @endif
        </div>

        <p class="flex justify-between">
            <small class="text-muted">Last
                updated {{ Carbon\Carbon::createFromTimestamp($model->last_edit)->diffForHumans() }}</small>
            <small class="text-muted">Size : {{ \App\Http\Livewire\ModelTable::humanFileSize($model->size) }}</small>
        </p>
    </div>
    <div class="md:w-1/5" wire:ignore>
        <div id="model_{{ $model->name }}" class="bg-white"
             style="height: 15em; border-top-right-radius: 3px; border-bottom-right-radius: 3px">
        </div>
        <script type="text/javascript">

            document.addEventListener("DOMContentLoaded", function () {
                console.log('created')
                create3DBox("{{ \Illuminate\Support\Facades\Storage::disk('public')->url($model->path) }}", "model_{{ $model->name }}")
            });

            window.livewire.on('reloadJs', event => {
                console.log('reloading js {{ $model->name }}')
                create3DBox("{{ \Illuminate\Support\Facades\Storage::disk('public')->url($model->path) }}", "model_{{ $model->name }}")
            });
        </script>
    </div>
</div>
