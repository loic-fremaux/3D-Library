<div class="flex flex-row">
    <div class="md:w-3/12">

        @include('includes.dropzone')

    </div>
    <div class="md:w-9/12">
        <script>
            Livewire.on('change-focus', function (id) {
                window.document.getElementById(id).focus();
            });
        </script>

        <div class="flex items-center justify-center my-8">
            <div class="flex border-2 rounded">
                <input type="text" class="px-4 py-2 w-80" placeholder="Search..." wire:model.debounce.300ms="search"/>
            </div>

            <div>
                @foreach($tags as $tag)
                    <span
                        class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none rounded-full @if(in_array($tag->id, $selectedTags)) text-red-100 bg-red-600 @endif"
                        wire:click="setTagSelected({{ $tag->id }})">{{ $tag->name }}</span>
                @endforeach

                @if($newTag === null)
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded-full"
                            wire:click="startCreatingTag">Create tag
                    </button>
                @else
                    <input
                        class="shadow appearance-none border border-red-500 rounded text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="new-tag" type="text" wire:model="newTag" wire:keydown.prevent.enter="createTag"/>
                @endif
            </div>
        </div>

        <div class="mx-5">
            @foreach($models as $model)
                <livewire:model-table :model="$model" :wire:key="'model-'.$model->id">
            @endforeach
        </div>
    </div>

    <script type="text/javascript">

        document.addEventListener("DOMContentLoaded", function () {
                let models = document.getElementsByClassName('3d-model');
                Array.from(models).forEach((model) => {
                    console.log('created ' + model.id)
                    create3DBox(model.getAttribute('data-link'), model.id)
                })
        });

        Livewire.on('reloadJs', function () {
            console.log('reload js')
            clearTasks();

            let models = document.getElementsByClassName('3d-model');
            Array.from(models).forEach((model) => {
                console.log('re-created ' + model.id)
                create3DBox(model.getAttribute('data-link'), model.id)
            })
        })
    </script>
</div>
