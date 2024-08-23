<?php

namespace App\Livewire\Amenities;

use App\Models\Amenities;
use Livewire\Component;

class AmenitiesTable extends Component
{
    public $search = '';
    public $name;
    public $price;

    public $selectedAmenities;
    public $updatePrice;
    public $updateName;



    public function render()
    {
        return view('livewire.amenities.amenities-table', [
            'amenities' => Amenities::search($this->search)->paginate(10)
        ]);
    }

    public function placeholder(){
        return view('loader');
    }

    public function updateAmenities($amenities)
    {
        $this->selectedAmenities = Amenities::find($amenities);
        $this->updateName = $this->selectedAmenities->Name;
        $this->updatePrice = $this->selectedAmenities->Price;
        $this->dispatch('open-modal', name: 'update-modal');
    }

    public function createAmenities()
    {
        Amenities::create([
            'Name' => $this->name,
            'Price' => $this->price
        ]);
        $this->dispatch('close-modal');
        session()->flash('message', 'Amenities Created successfully.');
        $this->name = '';
        $this->price = '';
    }

    public function update()
    {
        $this->selectedAmenities->update([
            'Name' => $this->updateName,
            'Price' => $this->updatePrice
        ]);
        $this->updateName = '';
        $this->updatePrice = '';
        $this->dispatch('close-modal');
        session()->flash('message', 'Amenities updated successfully.');
    }

    public function delete($id)
    {
        Amenities::find($id)->delete();
        session()->flash('message', 'Amenities deleted successfully.');
        $this->dispatch('close-modal');
    }
}
