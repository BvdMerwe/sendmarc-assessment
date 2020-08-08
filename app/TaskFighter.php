<?php

namespace App;

class TaskFighter
{
    public $name;

    public $priority;

    public $dueIn;

    public function __construct($name, $priority, $due_in)
    {
        $this->name = $name;
        $this->priority = $priority;
        $this->dueIn = $due_in;
    }

    public static function of($name, $priority, $dueIn) {
        return new static($name, $priority, $dueIn);
    }

    public function tick()
    {
        if ($this->name == 'Breathe') {
            return $this->handle_breathe();
        }
        if ($this->name == 'Get Older') {
            return $this->handle_get_older();
        }
        if ($this->name == 'Complete Assessment') {
            return $this->handle_complete_assesment();
        }

        /* Handle regular tasks */

        $this->handle_normal_task();

        // if ($this->name != 'Get Older') {
        //     if ($this->priority < 100) {
        //         if ($this->name != 'Breathe') {
        //             $this->priority = $this->priority + 1;
        //         }
        //     }
        //     if ($this->name == 'Complete Assessment') {
        //         if ($this->dueIn < 11) {
        //             if ($this->priority < 100) {
        //                 $this->priority = $this->priority + 1;
        //             }
        //         }
        //         if ($this->dueIn < 6) {
        //             if ($this->priority < 100) {
        //                 $this->priority = $this->priority + 1;
        //             }
        //         }
        //     }
        // } else {
        //     if ($this->priority > 0) {
        //         $this->priority = $this->priority - 1;
        //     }
        // }
        // if ($this->name != 'Breathe') {
        //     $this->dueIn = $this->dueIn - 1;
        // }
        // if ($this->dueIn < 0) {
        //     if ($this->name != 'Get Older') {
        //         if ($this->name != 'Complete Assessment') {
        //             if ($this->priority < 100) {
        //                 if ($this->name != 'Breathe') {
        //                     $this->priority = $this->priority + 1;
        //                 }
        //             }
        //         } else {
        //             $this->priority = $this->priority - $this->priority;
        //         }
        //     } else {
        //         if ($this->priority > 0) {
        //             $this->priority = $this->priority - 1;
        //         }
        //     }
        // }

    }

    private function handle_get_older() {
        //negate 2 from priority so that it negates one when processed
        $this->priority -= 2;
        $this->handle_normal_task();
    }

    private function handle_breathe() {
        //- "Breathe", being something that just happens, never has to be completed or increase in priority
        // "Breathe" is an automatic task and as such its priority is 1000 and it never alters.
        $this->priority = 1000;
    }

    private function handle_complete_assesment() {
        //- "Complete Assessment" increases in priority as it's dueIn value approaches
        //Priority increases by 2 when there are 10 days or less and by 3 when there are 5 days or less but priority drops to 0 after the due date.

        if ($this->dueIn > 10) {
            $this->handle_normal_task();
        } elseif ($this->dueIn <= 10 && $this->dueIn > 5) {
            $this->priority += 1;
            $this->handle_normal_task();
        } elseif ($this->dueIn <= 5 && $this->dueIn > 3) {
            $this->priority += 2;
            $this->handle_normal_task();
        } else {
            $this->priority = -2;
            $this->handle_normal_task();
        }
    }

    private function handle_normal_task() {
        // - At the end of each day our system lowers the dueIn value
        $this->dueIn -= 1;
        // and increases the priority value for every item
        $this->priority += 1;
        // - Once the due date has passed, priority increases twice as fast
        if ($this->dueIn < 0) {
            $this->priority += 1;
        }
        // - The priority of an item is never negative
        if ($this->priority < 0) {
            $this->priority = 0;
        }
        // - The priority of an item is never more than 100
        if ($this->priority > 100) {
            $this->priority = 100;
        }
    }
}
