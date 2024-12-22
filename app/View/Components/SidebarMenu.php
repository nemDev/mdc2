<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class sidebarMenu extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $importers = \Illuminate\Support\Facades\Config::get('import_types');
        $importersLinks = [];

        foreach ($importers as $key => $importer){
            foreach ($importer['files'] as $fileKey => $file){
                $importersLinks[] = [
                    'label' => $importer['label'] . ' ' . $file['label'],
                    'url' => $key .  '/' . $fileKey
                ];
            }
        }
        return view('components.sidebar-menu')->with('importersLinks', $importersLinks);
    }
}
