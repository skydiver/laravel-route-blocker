<?php

namespace Skydiver\LaravelRouteBlocker\Console;

use Illuminate\Console\Command;

class GroupsList extends Command
{
    protected $name        = 'route:blocks:groups';
    protected $description = 'Lists routes blocks groups.';

    protected $table;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Laravel 5.5 and superior
        $this->fire();
    }

    public function fire()
    {
        $allow   = config('laravel-route-blocker.whitelist');
        $block   = config('laravel-route-blocker.blacklist');
        $headers = ['Group', 'IP', 'Type'];

        $list = array_merge(
            $this->parseGroup($allow, 'whitelist'),
            $this->parseGroup($block, 'blacklist')
        );

        $this->table($headers, $list);
    }

    private function parseGroup($group, $type)
    {
        if (!is_array($group)) {
            return [];
        }

        $list = [];

        foreach ($group as $name => $addrs) {
            foreach ($addrs as $addr) {
                $list[] = [
                    $name, $addr, $type
                ];
            }
        }

        return $list;
    }
}
