<template>
  <div>
    <b-list-group v-if="loading">
      <b-list-group-item v-if="loading">
        <b-skeleton animation="throb" width="85%"></b-skeleton>
        <b-skeleton animation="throb" width="55%"></b-skeleton>
        <b-skeleton animation="throb" width="70%"></b-skeleton>
      </b-list-group-item>
    </b-list-group>
    <b-list-group v-else>
      <strong class="mb-3">
        Jumlah Tugas : {{tasks.length}}
      </strong>
      <b-list-group-item v-if="tasks.length === 0">
        <b-alert show variant="info">
          Belum ada tugas baru !
        </b-alert>
      </b-list-group-item>

      <b-list-group-item v-else v-for="task in tasks" :key="task.id">
        <b-row>
          <b-col>
            <strong>{{task.judul}}</strong>
          </b-col>
          <b-col>
            <b-button v-b-modal.show-task @click="ShowTask(task)" variant="info" size="sm">
              <i class="fas fa-fw fa-binoculars"></i>
            </b-button> &nbsp;

            <b-button @click.prevent="RemoveTask(task.id)" variant="danger" size="sm">
              <i class="far fa-fw fa-trash-alt"></i>
            </b-button> &nbsp;

            <b-button v-if="!task.finish" @click.prevent="FinishTask(task.id, true, 'Finished')" variant="success" size="sm">
              <i class="far fa-fw fa-calendar-check"></i>
            </b-button>
            <b-button v-else @click.prevent="FinishTask(task.id, false, 'Restored')" variant="warning" size="sm">
              <i class="fas fa-fw text-white fa-power-off"></i>
            </b-button>
          </b-col>
        </b-row>
      </b-list-group-item>
    </b-list-group>

    <b-modal id="show-task" title="Detail Task" hide-footer no-close-on-backdrop>
      <b-list-group>
        <b-list-group-item>
          ID : {{task.id}}
        </b-list-group-item>
        <b-list-group-item>
          <strong>
            {{task.judul}}
          </strong>
        </b-list-group-item>
        <b-list-group-item>
          {{task.time}}
        </b-list-group-item>
        <b-list-group-item v-if="task.finish">
          <strong>
            Status :
          </strong><i class="fas fa-fw text-success fa-clipboard-check"></i>
        </b-list-group-item>
        <b-list-group-item v-else>
          <strong>
            Status :
          </strong><i class="fas fa-fw text-danger fa-power-off"></i>
        </b-list-group-item>
      </b-list-group>
    </b-modal>

  </div>
</template>

<script>
  export default {
    props: ['tasks',
      'loading'],
    data() {
      return {
        task: {}
      }
    },

    mounted() {},

    methods: {
      ShowTask(task) {
        this.task = task
      },
      RemoveTask(id) {
        //calling parent method & sending data
        this.$emit("remove-task", id)
      },

      FinishTask(id, finish, text) {
        this.$emit("finish-task", id, finish, text)
      }

    }
  }
  </script>