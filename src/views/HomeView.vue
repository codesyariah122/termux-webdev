<template>
  <div class="home">
    <b-container>
      <b-row>
        <b-col>
          <h3>Task Lists</h3>
        </b-col>
        <b-col>
          <b-button v-b-modal.add-task variant="primary" size="sm">
            <i class="fas fa-fw fa-folder-plus"></i> Add Task
          </b-button>
        </b-col>
        <b-col lg="12" sm="12">
          <b-modal id="add-task" title="Add New Task" hide-footer no-close-on-backdrop>
            <form @submit.prevent="AddTask">
              <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" v-model="field.judul" class="form-control">
              </div>
              <div class="form-group mt-2">
                <b-button variant="primary" type="submit">
                  <div v-if="loading">
                    <b-spinner small></b-spinner>
                    Loading...
                  </div>
                  <div v-else>
                    Add Task
                  </div>
                </b-button>
              </div>
            </form>
          </b-modal>
        </b-col>
      </b-row>

      <!-- List tasks -->
      <b-row class="mt-5">
        <b-col>
          <Lists :tasks="tasks" :loading="loading" @remove-task="RemoveTask" @finish-task="FinishTask" />
        </b-col>
      </b-row>

    </b-container>
  </div>
</template>

<script>
  import moment from 'moment'
  import {
    random,
    time
  } from '@/utils'

  import {
    Lists
  } from "@/components"

  export default {
    name: 'HomeView',
    components: {
      Lists
    },
    data() {
      return {
        field: {},
        loading: null,
        tasks: [],
        newData: null,
        timeNow: moment(new Date()).utc("+0700").locale("id").format("LLL")
      }
    },

    mounted() {
      this.SetupTask()
    },

    methods: {
      SetupTask() {
        if (this.tasks.length > 0 || this.newData) {
          const task = localStorage.getItem("tasks") ?
          JSON.parse(localStorage.getItem("tasks")): ""
          this.tasks = [...Object.keys(task)]
        } else {
          const task = localStorage.getItem("tasks") ? JSON.parse(localStorage.getItem("tasks")): ""
          this.tasks = [...task]
        }
      },

      AddTask() {
        const data = {
          judul: this.field.judul
        }
        if (data.judul === "" || data.judul === undefined) {
          alert("Form input harus diisi!")
        } else {
          this.loading = true
          this.tasks.push({
            id: random(),
            time: this.timeNow,
            judul: data.judul,
            finish: false
          })
          this.newData = true

          setTimeout(()=> {
            this.loading = false
            this.BootstrapModal("hide", "add-task")
            this.field = {}
          }, 1500)
          setTimeout(()=> {
            localStorage.setItem("tasks", JSON.stringify(this.tasks))
          }, 2500)
        }
      },

      RemoveTask(id) {
        this.$swal({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            this.loading = true
            //seleksi data
            const find = this.tasks.findIndex(d=>d.id === id)
            setTimeout(()=> {
              this.loading = false
              this.$swal(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
              //deleting tasks data by find index array
              this.tasks.splice(find, 1)
              //replace new data after delete by index
              localStorage.setItem("tasks", JSON.stringify(this.tasks))
            }, 1500)
          } else {
            this.$swal(
              'Cancel',
              'Cancel Delete Data!',
              'error'
            )
          }
        })
      },

      FinishTask(id,
        finish,
        text) {
        const swalWithBootstrapButtons = this.$swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success btn-sm',
            cancelButton: 'btn btn-danger btn-sm'
          },
          buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: `Yes, ${text} it!`,
          cancelButtonText: 'No, cancel!',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            this.loading = true
            const task = this.tasks.findIndex(d=> {
              if (d.id === id) {
                this.tasks.push({
                  ...d, finish: finish
                })
              }
            })

            const findIdx = this.tasks.findIndex(d=>d.id === id)
            this.tasks.splice(findIdx,
              1)

            setTimeout(()=> {
              swalWithBootstrapButtons.fire(
                'Deleted!',
                `Your task has been ${text}.`,
                'success'
              )
              localStorage.setItem("taskd", this.tasks)
              this.loading = false
            },
              1500)

          } else if (
            /* Read more about handling dismissals below */
            result.dismiss === this.$swal.DismissReason.cancel
          ) {
            swalWithBootstrapButtons.fire(
              'Cancelled',
              'Your imaginary file is safe :)',
              'error'
            )
          }
        })
      },

      BootstrapModal(opt,
        id) {
        if (opt === "hide") {
          this.$bvModal.hide(id)
        } else {
          this.$bvModal.show(id)
        }
      }
    }
  }
  </script>