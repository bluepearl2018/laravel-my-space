<?php

namespace Eutranet\MySpace\View\Composers;

use Illuminate\View\View;

class MySpaceConfigComposer
{
    public function __construct()
    {
        $this->config = config('eutranet-my-space');
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view
            ->with('name', $this->config['name'])
            ->with('description', $this->config['description'])
            ->with('tables', $this->config['tables'])
            ->with('migrations', $this->config['migrations'])
        ;
    }
}
