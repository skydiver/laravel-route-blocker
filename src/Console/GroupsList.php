<?php

    namespace Skydiver\LaravelRouteBlocker\Console;

    use Illuminate\Console\Command;

    class GroupsList extends Command {

        protected $name        = 'route:blocks:groups';
        protected $description = 'Lists routes blocks groups.';

        protected $table;

        public function __construct() {
            parent::__construct();
        }

        public function fire() {

            $allow = config('laravel-route-blocker.whitelist');
            $list  = [];

            $this->table = $this->getHelperSet()->get('table');

            if(is_array($allow)) {
                foreach($allow as $name => $addrs) {
                    foreach($addrs as $addr) {
                        $list[] = [
                            $name, $addr
                        ];
                    }
                }
            }

            $this->table->setHeaders(['Group', 'IP'])->setRows($list);
            $this->table->render($this->getOutput());

        }


    }

?>