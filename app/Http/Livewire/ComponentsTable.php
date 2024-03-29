<?php

namespace App\Http\Livewire;

use App\Models\Model3D;
use App\Models\Tag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ComponentsTable extends Component
{

    use WithFileUploads;

    public $newFiles = [];

    public ?string $newTag = null;

    public string $search = '';

    public array $selectedTags = [];

    protected $listeners = ['renderParent'];

    public function mount()
    {
    }

    public function renderParent()
    {
        $this->render();
    }

    public function setTagSelected(int $tagId)
    {
        foreach ($this->selectedTags as $key => $tag) {
            if ($tag === $tagId) { // element found in array
                unset($this->selectedTags[$key]);
                $this->emit('reloadJs');
                return;
            }
        }

        // element not found in array
        $this->selectedTags[] = $tagId;

        $this->emit('reloadJs');
    }

    public function startCreatingTag()
    {
        $this->newTag = '';
        $this->emit('change-focus', 'new-tag');
    }

    public function cancelTagCreation()
    {
        $this->newTag = null;
    }

    public function createTag()
    {
        if (Tag::where('name', $this->newTag)->count() > 0) {
            dd('tag already exists');
        }

        Tag::create([
            "name" => $this->newTag,
        ]);

        $this->newTag = null;
    }

    public function updatedSearch()
    {
        $this->emit('reloadJs');
    }

    public function updatedNewFiles()
    {
        foreach ($this->newFiles as $file) {
            if (!str_ends_with($file->getClientOriginalName(), '.stl') && !str_ends_with($file->getClientOriginalName(), '.obj')) {
                continue;
            }

            if (Storage::disk('public')->missing($file->getClientOriginalName())) {
                $orig = $file->getFilename();
                $file->storeAs('/', $file->getClientOriginalName(), 'public');

                Model3D::create([
                    'name' => $file->getClientOriginalName(),
                    'path' => '/' . $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'last_edit' => time(),
                ]);

                Storage::delete('livewire-tmp/' . $orig);
            } else {
                $orig = $file->getFilename();
                $file->storeAs('/', $file->getClientOriginalName(), 'public');

                Model3D::where('name', $file->getClientOriginalName())->update([
                    'path' => '/' . $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'last_edit' => time(),
                ]);

                Storage::delete('livewire-tmp/' . $orig);
            }
        }

        $this->newFiles = [];

        $this->render();
        $this->emit('updated');
        $this->emit('reloadJs');
    }

    public function rules()
    {
        return [
            'newFiles.*' => 'max:524288',
        ];
    }

    public function render()
    {
        $tagsQuery = Model3D::where('name', 'LIKE', "%" . $this->search . "%");

        if (count($this->selectedTags) > 0) {
            $tagsQuery->whereHas('tags', function ($q) {
                    $q->whereIn('id', $this->selectedTags);
            });
        }

        return view('livewire.components-table', [
            'models' => $tagsQuery->get(),
            'tags' => Tag::all(),
        ]);
    }
}
