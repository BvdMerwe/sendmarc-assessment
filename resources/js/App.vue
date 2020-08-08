<template>
  <div id="app">
      <h1 class="center-text">Welcome to Taskfighter</h1>
      <div class="task-list">
          <div class="list-heading">
              <div @click="sortByName">task name</div>
              <div class="justify-center" @click="sortByDue">due in</div>
              <div class="justify-right" @click="sortByPriority">priority</div>
          </div>
          <Task v-for="task in tasks" :key="task.id" :task="task" />
      </div>
  </div>
</template>

<script>
import Task from "./components/Task.vue";
export default {
    name: 'App',
    components: {
        Task
    },
    data() {
        return {
            tasks: []
        }
    },
    methods: {
        fetchTasks() {
            fetch('/tasks')
            .then(res => res.json())
            .then(res => {
                this.tasks = res;
            })
        },
        sortByPriority() {

        },
        sortByName() {

        },
        sortByDue() {

        }
    },
    created() {
        this.fetchTasks()
    }
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
</style>