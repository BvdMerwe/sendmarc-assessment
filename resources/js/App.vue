<template>
  <div id="app">
      <h1 class="center-text">Welcome to Taskfighter</h1>
      <div class="task-list">
          <div v-if="tasks.length == 0" class="list-warning">
              No tasks to display
          </div>
          <div v-if="tasks.length > 0" class="list-heading">
              <div class="justify-left" @click="sortByName">task name</div>
              <div class="justify-center" @click="sortByDue">due in</div>
              <div class="justify-right" @click="sortByPriority">priority</div>
          </div>
          <Task v-for="task in tasks" :key="task.id" :task="task" />
          <button class="tick-button" @click="tickTasks" v-if="tasks.length > 0">{{ tickMessage }}</button>
      </div>
  </div>
</template>

<script>
import helpers from './mixins/helpers.js';
import Task from "./components/Task.vue";
export default {
    name: 'App',
    components: {
        Task
    },
    data() {
        return {
            tasks: [],
            tickMessage: "TICK!"
        }
    },
    methods: {
        setTasks(data) {
           this.tasks = data;
        },
        fetchTasks() {
            fetch('/tasks')
            .then(res => res.json())
            .then(res => {
                this.setTasks(res)
                console.log(res);
            })
        },
        tickTasks() {
            this.tickMessage = "TICKING..."
            fetch('/list/tick')
            .then(res => res.json())
            .then(res => {
                this.fetchTasks();
                this.tickMessage = "TICK!"
            });
        },
        sortByPriority() {
            this.tasks = this.tasks.slice().sort((a, b) => { 
                return a.priority == b.priority ? 0 : a.priority > b.priority ? -1 : 1;
            });
            // console.log(newArray[0].priority)
        },
        sortByName() {
            this.tasks = this.tasks.slice().sort((a, b) => { 
                return a.name.localeCompare(b.name);
            });
            // console.log(newArray[0].name)
        },
        sortByDue() {
            this.tasks = this.tasks.slice().sort((a, b) => { 
                return a.dueIn == b.dueIn ? 0 : a.dueIn < b.dueIn ? -1 : 1;
            });
            // console.log(newArray[0].dueIn)
        }
    },
    created() {
        this.fetchTasks()
    },
    mixins: [helpers]
}
</script>

<style lang="scss">
@import '../sass/variables.scss';
html, body {
    background-color: $dark;

    color: $light;
}

h1, h2, h3, h4, h5 {
    color: $headings;
}

.center-text {
    text-align: center;
}

.align-center {
    align-self: center;
}
.justify-center {
    justify-self: center;
}
.justify-right {
    justify-self: right;
}

#app { 
    display: grid;
    align-items: center;
    justify-content: center;
}

.task-list {
    display: grid;
    align-items: center;
    justify-content: center;
    row-gap: 10px;
}

.list-heading {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    padding: 0px 10px;
    font-size: 0.625em;
    font-weight: bold;
    text-transform: uppercase;
    div {
        cursor: pointer;
    }
}

.tick-button {
    background: #fff;
    border: none;
    border-radius: 100px;
    height: 4em;
    display: inline-block;
    width: auto;
    outline: none;
}
</style>