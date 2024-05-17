<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class Categories extends Component
{
    public $categories, $title, $category_id;
    public $updateMode = false;
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        $this->categories = Category::latest()->get();
        return view('livewire.categories');
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->title = '';        
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $validatedDate = $this->validate([
            'title' => 'required',
        ]);
  
        Category::create($validatedDate);
  
        session()->flash('message', 'Category Created Successfully.');
  
        $this->resetInputFields();
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->category_id = $id;
        $this->title = $category->title;
  
        $this->updateMode = true;
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function update()
    {
        $validatedDate = $this->validate([
            'title' => 'required',
        ]);
  
        $category = Category::find($this->category_id);
        $category->update([
            'title' => $this->title,
        ]);
  
        $this->updateMode = false;
  
        session()->flash('message', 'Category Updated Successfully.');
        $this->resetInputFields();
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Category::find($id)->delete();
        session()->flash('message', 'Category Deleted Successfully.');
    }
}
