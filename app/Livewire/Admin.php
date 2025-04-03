<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AdsTrack;
use App\Models\AdsForm;

class Admin extends Component
{
    use WithPagination;
    public $totalClicks;
    public $convertedClicks;
    public $totalUniqueClicks;
    public $totalForms;
    public $search = '';
    
    public function mount()
    {
        $this->totalClicks = AdsTrack::sum('clicks');
        $this->convertedClicks = AdsTrack::where('form_filled', true)->count();
        $this->totalUniqueClicks = AdsTrack::count();
        $this->totalForms = AdsForm::count();


    }


    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatedPerPage()
    {
        $this->resetPage();
    }



    public function deleteAdsForm($id)
    {
        $adsForm = AdsForm::find($id);
        if ($adsForm) {
            $adsForm->delete();
            session()->flash('message', 'Ads Form deleted successfully.');
        } else {
            session()->flash('error', 'Ads Form not found.');
        }
        
        $this->adsForms = AdsForm::paginate(10);
    }

    public function render()
    {

        $adsForms = AdsForm::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('phone', 'like', '%' . $this->search . '%')
            ->orWhere('location', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin' , [
            'adsForms' => $adsForms,
        ]);
    }
}


