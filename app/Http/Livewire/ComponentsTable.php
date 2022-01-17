<?php

namespace App\Http\Livewire;

use App\Models\Model3D;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;

class ComponentsTable extends Component
{

    use WithFileUploads;

    public $models;

    public $newFiles = [];

    public function mount($models)
    {
        $this->models = $models;
    }

    public function download($filePath)
    {
        return \Storage::disk('public')->download($filePath);
    }

    public function updatedNewFiles()
    {
        foreach ($this->newFiles as $file) {
            if (Storage::disk('public')->missing($file->getClientOriginalName())) {
                $orig = $file->getFilename();
                $file->storeAs('/', $file->getClientOriginalName(), 'public');

                Model3D::create([
                    'name' => $file->getClientOriginalName(),
                    'path' => '/' . $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'last_edit' => time(),
                ]);

                Storage::delete('livewire-tmp/' . $orig); // remove temporary files
            } else {
                // dd('file already exists');
            }
        }

        $this->newFiles = [];

        $this->render();
        $this->emit('updated');
    }

    public function rules()
    {
        return [
            'newFiles' => 'max:2048000',
            'files' => 'file|max:2048000',
        ];
    }

    public function render()
    {
        return view('livewire.components-table', [
            'models' => $this->models
        ]);
    }
}
