<?php

namespace Vwl\FileExplorer;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class FileExplorer extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('file-explorer', __DIR__ . '/../dist/js/tool.js');
        Nova::style('file-explorer', __DIR__ . '/../dist/css/tool.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        $title = config('file-explorer.tool_title');
        return view('file-explorer::navigation', ['title' => $title]);
    }
}
