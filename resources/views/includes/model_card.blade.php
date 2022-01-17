<div class="my-5 w-full rounded-lg shadow-lg overflow-hidden flex flex-col md:flex-row">
    <div class="bg-white w-full md:w-4/5 text-left p-6 md:p-4 space-y-2 flex flex-col justify-between">
        <div class="flex flex-row justify-between">
            <h2 class="text-2xl font-semibold text-gray-700 capitalize dark:text-white">{{ $model['name'] }}</h2>
            <button class="bg-grey hover:bg-grey text-grey-darkest font-bold py-2 px-4 rounded inline-flex items-center" wire:click="download('{{ $model['file'] }}')">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                <span>Download</span>
            </button>
        </div>

        <p class="text-gray-500 dark:text-gray-300">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur
            dolorem
            nesciunt voluptates? Ad consequatur dolorum ducimus necessitatibus quidem sunt unde! Aperiam beatae
            dolores ea earum eveniet iste obcaecati, perferendis possimus.
        </p>

        <p class="flex justify-between">
            <small class="text-muted">Last updated {{ $model['last_edit'] }}</small>
            <small class="text-muted">Size : {{ $model['size'] }}</small>
        </p>
    </div>
    <div class="md:w-1/5" wire:ignore>
        <div id="model_{{ $model['name'] }}" class="bg-white"
             style="height: 15em; border-top-right-radius: 3px; border-bottom-right-radius: 3px">
        </div>
    </div>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            create3DBox("{{ $model['link'] }}", "model_{{ $model['name'] }}")
        });
    </script>
</div>
