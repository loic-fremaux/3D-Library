<div class="my-5 w-full rounded-lg shadow-lg overflow-hidden flex flex-col md:flex-row">
    <div class="bg-white w-full lg:w-4/5 text-left p-6 p-4 space-y-2 flex flex-col justify-between">
        <div class="flex flex-col md:flex-row justify-between">
            <h2 class="text-1xl md:text-2xl font-semibold text-gray-700 capitalize">{{ $model->name }}</h2>
            <div>
                <button
                    class="border-2 border-red-500 font-bold py-2 px-4 rounded inline-flex items-center
                    @if($modelRemoveId === $model->id) bg-red-500 text-white
                    @else hover:bg-red-500 hover:text-white text-red-500  @endif"
                    wire:click="removeModel({{ $model->id }})">
                    Remove
                </button>
                <button
                    class="border-2 border-gray-600 hover:bg-gray-100 font-bold py-2 px-4 text-gray-600 rounded inline-flex items-center"
                    wire:click="download('{{ $model->path }}')">
                    Download
                </button>
            </div>
        </div>

        @if($editing)
            <textarea id="model-description-editing-{{ $model->id }}"
                      class="shadow appearance-none bg-white text-black border border-blue-500"
                      wire:model.defer="model.description">
                {{ $model->description }}
            </textarea>
            <div class="flex justify-end">
                <button
                    class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-1 px-2 w-16 mx-1"
                    wire:click="setEditing(false)">Cancel
                </button>
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-2 w-16"
                    wire:click="saveDescription({{ $model->id }})">Save
                </button>
            </div>
        @else
            <p class="text-gray-500" wire:click="setEditing(true)">
                {{ $model->description ?? 'Click here to add a description' }}
            </p>
        @endif

        <div>
            @foreach($tags as $tag)
                <span class="pointer inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none rounded-full
                     text-white bg-gray-500 @if($tagRemoveId === $tag->id) outline outline-offset-1 outline-red-500 @endif"
                      wire:click="detachTag({{ $tag->id }})">{{$tag->name}}</span>
            @endforeach

            @if($newTagName === null)
                <button class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-2 rounded-full"
                        wire:click="searchTag">Add tag
                </button>
            @else
                <input
                    class="shadow appearance-none bg-white border border-blue-500 rounded text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    id="add-tag-{{ $model->id }}" type="text" wire:model="newTagName"
                    wire:keydown.enter="addTag">
                <button
                    class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-1 px-2 w-16 mx-1"
                    wire:click="cancelTagResearch">Cancel
                </button>
            @endif
        </div>

        <p class="flex justify-between">
            <small class="text-muted text text-black">Last
                updated {{ Carbon\Carbon::createFromTimestamp($model->last_edit)->diffForHumans() }}</small>
            <small class="text-muted text text-black">Size
                : {{ \App\Http\Livewire\ModelTable::humanFileSize($model->size) }}</small>
        </p>
    </div>
    <div class="lg:w-1/5 md:w-64 w-full">
        <div id="model_{{ $model->name }}"
             data-link="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($model->path) }}"
             class="bg-white 3d-model"
             style="height: 15em; border-top-right-radius: 3px; border-bottom-right-radius: 3px" wire:ignore>
        </div>
    </div>
</div>
