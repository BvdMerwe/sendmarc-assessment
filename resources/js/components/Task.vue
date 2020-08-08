<template>
  <div class="task">
      <div class="name">{{name}}</div>
      <div class="dueIn justify-center">{{dueIn}}</div>
      <div class="priority justify-right">{{priority}}</div>
  </div>
</template>

<script>
export default {
    name: "Task",
    props: {
        task: {
            type: Object
        }
    },
    data() {
        return {
            name: "",
            dueIn: "",
            priority: ""
        }
    },
    methods: {
        populateInfo() {
            this.name = this.task.name;
            this.dueIn = this.task.dueIn;
            this.priority = this.task.priority;
        }
    },
    created() {
        this.populateInfo()
    },
    watch: {
        task(newTask, oldTask) {
            this.populateInfo();
        }
    }
}
</script>

<style lang="scss">
@import '../../sass/variables.scss';

.task {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    padding: 15px 10px;
    border-radius: 10px;
    background-color: rgba($decoration-color, 1);
}
</style>