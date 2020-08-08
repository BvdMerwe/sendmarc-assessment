<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\TaskFighter;

class TaskFighterTest extends TestCase
{
    /**
     * Test if Taskfighter constructor works as expected
     */
    public function test_taskfighter_constructor() {
        fwrite(STDERR, print_r(__FUNCTION__.PHP_EOL, TRUE));
        $name = 'test';
        $dueIn = 200;
        $priority = 50;
        $tf = new TaskFighter($name, $priority, $dueIn);

        // if ($tf->name == $name) 

        $this->assertTrue($tf->name == $name, __FUNCTION__.' name');
        $this->assertTrue($tf->dueIn == $dueIn, __FUNCTION__.' dueIn');
        $this->assertTrue($tf->priority == $priority, __FUNCTION__.' priority');
    }
    /**
     * Test if Taskfighter tick works as expected with breathe
     */
    public function test_taskfighter_tick_breathe() {
        fwrite(STDERR, print_r(__FUNCTION__.PHP_EOL, TRUE));
        $name = 'Breathe';
        $dueIn = 300;
        $priority = 200;
        $tf = new TaskFighter($name, $priority, $dueIn);

        $tf->tick();

        $this->assertTrue($tf->name == $name, __FUNCTION__.' name');
        $this->assertTrue($tf->dueIn == $dueIn, __FUNCTION__.' dueIn');
        $this->assertTrue($tf->priority == 1000, __FUNCTION__.' priority');
    }
    /**
     * Test if Taskfighter tick works as expected with Get Older 
     */
    public function test_taskfighter_tick_get_older() {
        fwrite(STDERR, print_r(__FUNCTION__.PHP_EOL, TRUE));
        $name = 'Get Older';
        $dueIn = 265;
        $priority = 50;
        $tf = new TaskFighter($name, $priority, $dueIn);

        $tf->tick();

        $this->assertTrue($tf->name == $name, __FUNCTION__.' name');
        $this->assertTrue($tf->dueIn == $dueIn - 1, __FUNCTION__.' dueIn');
        $this->assertTrue($tf->priority == $priority - 1, __FUNCTION__.' priority');
    }

    /**
     * Test if Taskfighter tick works as expected with Complete Assessment
     */
    public function test_taskfighter_tick_complete_assessment() {
        fwrite(STDERR, print_r(__FUNCTION__.PHP_EOL, TRUE));
        $this->test_taskfighter_tick_greater_than_ten_days();
        $this->test_taskfighter_tick_less_than_ten_days();
        $this->test_taskfighter_tick_less_than_five_days();
        $this->test_taskfighter_tick_due_passed();
    }

    public function test_taskfighter_tick_greater_than_ten_days() {
        fwrite(STDERR, print_r(__FUNCTION__.PHP_EOL, TRUE));
        $name = 'Complete Assessment';
        $dueIn = 11;
        $priority = 50;
        $tf = new TaskFighter($name, $priority, $dueIn);

        $tf->tick();

        $this->assertTrue($tf->name == $name, __FUNCTION__.' name');
        $this->assertTrue($tf->dueIn == $dueIn - 1, __FUNCTION__.' dueIn');
        $this->assertTrue($tf->priority == $priority + 1, __FUNCTION__.' priority');
    }
    public function test_taskfighter_tick_less_than_ten_days() {
        fwrite(STDERR, print_r(__FUNCTION__.PHP_EOL, TRUE));
        $name = 'Complete Assessment';
        $dueIn = 9;
        $priority = 50;
        $tf = new TaskFighter($name, $priority, $dueIn);

        $tf->tick();

        $this->assertTrue($tf->name == $name, __FUNCTION__.' name');
        $this->assertTrue($tf->dueIn == $dueIn - 1, __FUNCTION__.' dueIn');
        $this->assertTrue($tf->priority == $priority + 2, __FUNCTION__.' priority');
    }
    public function test_taskfighter_tick_less_than_five_days() {
        fwrite(STDERR, print_r(__FUNCTION__.PHP_EOL, TRUE));
        $name = 'Complete Assessment';
        $dueIn = 4;
        $priority = 50;
        $tf = new TaskFighter($name, $priority, $dueIn);

        $tf->tick();

        $this->assertTrue($tf->name == $name, __FUNCTION__.' name');
        $this->assertTrue($tf->dueIn == $dueIn - 1, __FUNCTION__.' dueIn');
        $this->assertTrue($tf->priority == $priority + 3, __FUNCTION__.' priority');
    }
    public function test_taskfighter_tick_due_passed() {
        fwrite(STDERR, print_r(__FUNCTION__.PHP_EOL, TRUE));
        $name = 'Complete Assessment';
        $dueIn = 0;
        $priority = 50;
        $tf = new TaskFighter($name, $priority, $dueIn);

        $tf->tick();

        $this->assertTrue($tf->name == $name, __FUNCTION__.' name');
        $this->assertTrue($tf->dueIn == $dueIn - 1, __FUNCTION__.' dueIn');
        $this->assertTrue($tf->priority == 0, __FUNCTION__.' priority');
    }
    /* END COMPLETE ASSESSMENT TESTS */

    /**
     * Test if Taskfighter tick works as expected with normal task
     */
    public function test_taskfighter_tick_normal_task() {
        fwrite(STDERR, print_r(__FUNCTION__.PHP_EOL, TRUE));

        $name = 'Test Task!';
        $dueIn = 50;
        $priority = 50;
        $tf = new TaskFighter($name, $priority, $dueIn);

        $this->taskfighter_tick_normal($tf);
        $tf->priority = -1;
        $this->taskfighter_tick_normal_negative_priority($tf);

        $tf->dueIn = -1;
        $this->taskfighter_tick_normal_passed_due($tf);

        //increase priority a lot
        for ($i = 0; $i < 100; $i++) {
            $tf->tick();
        }
        $this->taskfighter_tick_normal_priority_over_100($tf);
    }
    public function taskfighter_tick_normal($tf) {
        fwrite(STDERR, print_r(__FUNCTION__.PHP_EOL, TRUE));

        $old_tf = new TaskFighter($tf->name, $tf->priority, $tf->dueIn);

        $tf->tick();

        $this->assertTrue($tf->name == $old_tf->name, __FUNCTION__.' name');
        $this->assertTrue($tf->dueIn == $old_tf->dueIn - 1, __FUNCTION__.' dueIn');
        $this->assertTrue($tf->priority == $old_tf->priority + 1, __FUNCTION__.' priority');
    }
    public function taskfighter_tick_normal_negative_priority($tf) {
        fwrite(STDERR, print_r(__FUNCTION__.PHP_EOL, TRUE));

        $old_tf = new TaskFighter($tf->name, $tf->priority, $tf->dueIn);

        $tf->tick();
        
        $this->assertTrue($tf->name == $old_tf->name, __FUNCTION__.' name');
        $this->assertTrue($tf->dueIn == $old_tf->dueIn - 1, __FUNCTION__.' dueIn');
        $this->assertTrue($tf->priority >= 0, __FUNCTION__.' priority');
    }
    public function taskfighter_tick_normal_passed_due($tf) {
        fwrite(STDERR, print_r(__FUNCTION__.PHP_EOL, TRUE));

        $old_tf = new TaskFighter($tf->name, $tf->priority, $tf->dueIn);

        $tf->tick();
        
        $this->assertTrue($tf->name == $old_tf->name, __FUNCTION__.' name');
        $this->assertTrue($tf->dueIn == $old_tf->dueIn - 1, __FUNCTION__.' dueIn');
        $this->assertTrue($tf->priority == $old_tf->priority + 2, __FUNCTION__.' priority');
    }
    public function taskfighter_tick_normal_priority_over_100($tf) {
        fwrite(STDERR, print_r(__FUNCTION__.PHP_EOL, TRUE));

        $old_tf = new TaskFighter($tf->name, $tf->priority, $tf->dueIn);

        $tf->tick();
        
        $this->assertTrue($tf->name == $old_tf->name, __FUNCTION__.' name');
        $this->assertTrue($tf->dueIn == $old_tf->dueIn - 1, __FUNCTION__.' dueIn');
        $this->assertTrue($tf->priority < 101, __FUNCTION__.' priority');
    }




}
