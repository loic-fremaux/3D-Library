<?php

namespace App\Http\Livewire;

use App\Models\Model3D;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use phpDocumentor\Reflection\DocBlock\Tag;

class ModelTable extends Component
{

    public $model;

    public bool $editing = false;

    public ?string $newTagName = null;

    public ?int $tagRemoveId = null;

    public ?int $modelRemoveId = null;

    public function mount($model)
    {
        $this->model = $model;
    }

    public function setEditing(bool $editing)
    {
        $this->editing = $editing;
        $this->model->description = $this->model->getOriginal('description');

        if ($editing) {
            $this->emit('change-focus', 'model-description-editing-' . $this->model->id);
        }
    }

    public function saveDescription()
    {
        $this->model->save();

        $this->setEditing(false);
    }

    public function searchTag()
    {
        $this->newTagName = '';
        $this->emit('change-focus', 'add-tag-' . $this->model->id);
    }

    public function cancelTagResearch()
    {
        $this->newTagName = null;
    }

    public function addTag()
    {
        $tag = \App\Models\Tag::where('name', $this->newTagName)->first();
        if ($tag === null) {
            dd('tag is null');
        }

        $this->model->tags()->attach($tag);
        $this->newTagName = null;
    }

    public function detachTag(int $id)
    {
        $tag = \App\Models\Tag::find($id);
        if ($tag === null) {
            dd('tag is null');
        }

        if ($this->tagRemoveId === null || $this->tagRemoveId !== $id) {
            $this->tagRemoveId = $id;
        } else {
            $this->model->tags()->detach($tag);
            $this->tagRemoveId = null;
        }
    }

    public function removeModel(int $id)
    {
        if ($this->modelRemoveId === null || $this->modelRemoveId !== $id) {
            $this->modelRemoveId = $id;
        } else {
            $model = Model3D::find($id);
            Storage::disk('public')->delete($model->path);

            $model->delete();

            $this->modelRemoveId = null;
            $this->emit('renderParent');
        }
    }

    public function download($filePath)
    {
        return Storage::disk('public')->download($filePath);
    }

    public static function humanFileSize($size, $unit = "")
    {
        if ((!$unit && $size >= 1 << 30) || $unit == "GB")
            return number_format($size / (1 << 30), 2) . "GB";
        if ((!$unit && $size >= 1 << 20) || $unit == "MB")
            return number_format($size / (1 << 20), 2) . "MB";
        if ((!$unit && $size >= 1 << 10) || $unit == "KB")
            return number_format($size / (1 << 10), 2) . "KB";
        return number_format($size) . " bytes";
    }

    public function rules()
    {
        return [
            'model.description' => 'string'
        ];
    }

    public function render()
    {
        return view('livewire.model-table', [
            'tags' => $this->model->tags()->get()
        ]);
    }
}
