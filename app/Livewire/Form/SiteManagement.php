<?php

namespace App\Livewire\Form;

use App\Models\Site;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class SiteManagement extends Component
{
    use WithFileUploads;

    public bool $isEdit = false;
    public ?Site $site = null;

    public string $name = '';
    public string $url = '';
    public string $title = '';
    public string $description = '';
    public string $keywords = '';
    public string $marquee = '';
    public string $type = '';
    public string $theme = '';

    public $logo = null;
    public $favicon = null;
    public $card = null;

    public bool $status = true;

    public function mount(): void
    {
        $siteId = Auth::user()?->site_id;

        if ($siteId && $site = Site::find($siteId)) {
            $this->isEdit = true;
            $this->site = $site;

            $this->name = $site->name;
            $this->url = $site->url;
            $this->title = $site->title;
            $this->description = $site->description;
            $this->keywords = $site->keywords;
            $this->marquee = $site->marquee;
            $this->type = $site->type;
            $this->theme = $site->theme;
            $this->status = (bool)$site->status;
        }
    }

    public function updatedType(): void
    {
        // reset theme tiap kali type berubah biar ga nyangkut theme yang salah
        $this->theme = '';
    }

    protected function rules(): array
    {
        $siteId = $this->site?->id;

        return [
            'name' => ['required', 'string', 'min:3'],
            'url' => [
                'required',
                'url',
                Rule::unique('sites', 'url')->ignore($siteId),
            ],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'keywords' => ['required', 'string'],
            'marquee' => ['required', 'string'],

            'type' => [
                'required',
                Rule::in(['nexus-amb', 'nexus-siam', 'infini', 'idn-sports', 'idn-slots', 'onix']),
            ],
            'theme' => ['required', 'string', 'max:50'],

            'status' => ['required', 'boolean'],

            'logo' => [$this->isEdit ? 'nullable' : 'required', 'image', 'max:2048'],
            'favicon' => [$this->isEdit ? 'nullable' : 'required', 'image', 'max:1024'],
            'card' => [$this->isEdit ? 'nullable' : 'required', 'image', 'max:4096'],
        ];
    }

    public function handleSubmit(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'url' => $this->url,
            'title' => $this->title,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'marquee' => $this->marquee,
            'type' => $this->type,
            'theme' => $this->theme,
            'status' => $this->status,
        ];

        $slugName = Str::slug($this->name) ?: 'site';

        $data['logo'] = $this->handleImageUpdate('logo', "sites/logo/{$slugName}");
        $data['favicon'] = $this->handleImageUpdate('favicon', "sites/favicon/{$slugName}");
        $data['card'] = $this->handleImageUpdate('card', "sites/card/{$slugName}");

        if ($this->isEdit && $this->site) {
            $this->site->update($data);
        } else {
            $this->site = Site::create($data);
            $this->isEdit = true;

            // optional: set site_id di user
            $user = Auth::user();
            if ($user && !$user->site_id) {
                $user->site_id = $this->site->id;
                $user->save();
            }
        }

        session()->flash('success', 'Site settings saved successfully ✅');
    }

    protected function handleImageUpdate(string $field, string $folder): ?string
    {
        $file = $this->{$field};

        if ($file) {
            if ($this->isEdit && $this->site?->{$field}) {
                Storage::disk('public')->delete($this->site->{$field});
            }

            return $file->store($folder, 'public');
        }

        return $this->isEdit ? $this->site?->{$field} : null;
    }

    /** Options untuk select type */
    public function getTypeOptionsProperty(): array
    {
        return [
            'nexus-amb' => 'Nexus AMB',
            'nexus-siam' => 'Nexus Siam',
            'infini' => 'Infini',
            'idn-sports' => 'IDN Sports',
            'idn-slots' => 'IDN Slots',
            'onix' => 'Onix',
        ];
    }

    /** Options untuk select theme tergantung type */
    public function getThemeOptionsProperty(): array
    {
        if (!$this->type) {
            return [];
        }

        if (in_array($this->type, ['nexus-amb', 'nexus-siam'], true)) {
            return [
                ['value' => 'light-blue', 'label' => 'Light Blue'],
                ['value' => 'light-gold', 'label' => 'Light Gold'],
                ['value' => 'dark-purple', 'label' => 'Dark Purple'],
                ['value' => 'dark-gold', 'label' => 'Dark Gold'],
                ['value' => 'dark-orange', 'label' => 'Dark Orange'],
                ['value' => 'dark-green', 'label' => 'Dark Green'],
                ['value' => 'red', 'label' => 'Red'],
                ['value' => 'blue-magenta', 'label' => 'Blue Magenta'],
            ];
        }

        $options = [];
        for ($i = 1; $i <= 40; $i++) {
            $options[] = [
                'value' => (string)$i,
                'label' => "Theme #{$i}",
            ];
        }

        return $options;
    }

    public function render(): View
    {
        return view('livewire.form.site-management');
    }
}
