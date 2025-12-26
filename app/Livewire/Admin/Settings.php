<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class Settings extends Component
{   
    use AuthorizesRequests;
    public $backup_percentage;
    public $default_bidder_percentage;
    public $default_developer_percentage;
    public $solo_developer_percentage;
    public $default_idle_percentage;

    public function mount()
    {
        $this->backup_percentage = $this->getSetting('backup_percentage', '10');
        $this->default_bidder_percentage = $this->getSetting('default_bidder_percentage', '30');
        $this->default_developer_percentage = $this->getSetting('default_developer_percentage', '60');
        $this->solo_developer_percentage = $this->getSetting('solo_developer_percentage', '80');
        $this->default_idle_percentage = $this->getSetting('default_idle_percentage', '10');
    }


    private function getSetting($key, $default)
    {
        return Setting::where('key', $key)->value('value') ?? $default;
    }

    public function updateSettings()
    {   
        $this->authorize('edit settings');
        // Validation keeps it numeric
        $this->validate([
            'backup_percentage' => 'required|numeric|min:0|max:100',
            'default_bidder_percentage' => 'required|numeric|min:0|max:100',
            'default_developer_percentage' => 'required|numeric|min:0|max:100',
            'solo_developer_percentage' => 'required|numeric|min:0|max:100',
            'default_idle_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $this->saveSetting('backup_percentage', $this->backup_percentage);
        $this->saveSetting('default_bidder_percentage', $this->default_bidder_percentage);
        $this->saveSetting('default_developer_percentage', $this->default_developer_percentage);
        $this->saveSetting('solo_developer_percentage', $this->solo_developer_percentage);
        $this->saveSetting('default_idle_percentage', $this->default_idle_percentage);

        session()->flash('message', 'Global settings updated successfully.');
    }

    private function saveSetting($key, $value)
    {   
        $this->authorize('edit settings');
        Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public function render()
    {   
        $this->authorize('view settings');
        return view('livewire.admin.settings')
            ->layout('layouts.app', ['title' => 'Global Configuration']);
    }
}