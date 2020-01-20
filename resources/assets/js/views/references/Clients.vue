
<template>
  <div>
    <notifications group="notification" />
    <div class="animated fadeIn">
      <!-- main div -->

      <b-row>
        <!-- main row -->
        <b-col sm="12">
          <b-card>
            <!-- main card -->
            <h5 slot="header">
              <!-- table header -->
              <span class="text-primary">
                <i class="fa fa-bars"></i>
                Clients List
                <small
                  class="font-italic"
                >List of all registered Clients .</small>
              </span>
            </h5>
            <b-row class="mb-2">
              <!-- row button and search input -->
              <b-col sm="4">
                <!-- <b-button
                  variant="primary"
                  @click="showModalEntry = true, entryMode='Add', clearFields('client')"
                >
                  <i class="fa fa-plus-circle"></i> Create New Departments
                </b-button>-->
              </b-col>

              <b-col sm="4">
                <span></span>
              </b-col>

              <b-col sm="4">
                <b-form-input v-model="filters.clients.criteria" type="text" placeholder="Search"></b-form-input>
              </b-col>
            </b-row>
            <!-- row button and search input -->

            <b-row>
              <!-- row table -->
              <b-col sm="12">
                <b-table
                  responsive
                  striped
                  hover
                  small
                  bordered
                  show-empty
                  :filter="filters.clients.criteria"
                  :fields="tables.clients.fields"
                  :items.sync="tables.clients.items"
                  :current-page="paginations.clients.currentPage"
                  :per-page="paginations.clients.perPage"
                >
                  <!-- table -->

                  <template v-slot:cell(action)="data">
                    <!-- action slot  :to="{path: 'departments/' + data.item.id } -->
                    <b-btn :size="'sm'" variant="primary" @click="setUpdate(data)">
                      <i class="fa fa-edit"></i>
                    </b-btn>

                    <b-btn
                      :size="'sm'"
                      :disabled="forms.client.isDeleting"
                      variant="danger"
                      @click="setDelete(data)"
                    >
                      <icon v-if="forms.client.isDeleting" name="sync" spin></icon>
                      <i v-else class="fa fa-trash"></i>
                    </b-btn>
                  </template>
                </b-table>
                <!-- table -->
              </b-col>
            </b-row>
            <!-- row table -->

            <b-row>
              <!-- Pagination -->
              <b-col sm="12" class="my-1">
                <b-pagination
                  size="sm"
                  align="center"
                  :total-rows="paginations.clients.totalRows"
                  :per-page="paginations.clients.perPage"
                  v-model="paginations.clients.currentPage"
                  class="my-0"
                />
              </b-col>
            </b-row>
            <!-- Pagination -->
          </b-card>
          <!-- main card -->
        </b-col>
      </b-row>
      <!-- main row -->
    </div>

    <div>
      <!-- modal div -->
    </div>
    <!-- modal div -->
  </div>
  <!-- main container -->
</template>
<script>
export default {
  name: "clients",
  data() {
    return {
      entryMode: "Add",
      showModalEntry: false, //if true show modal
      showModalDelete: false,
      forms: {
        client: {
          isSaving: false,
          isDeleting: false,
          fields: {}
        }
      },
      tables: {
        clients: {
          fields: [
            {
              key: "client_id",
              label: "Client ID",
              thStyle: { width: "150px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "client_name",
              label: "Client Name",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "department_name",
              label: "Department",
              tdClass: "align-middle",
              sortable: true
            },

            {
              key: "action",
              label: "",
              thStyle: { width: "80px" },
              tdClass: "text-center"
            }
          ],
          items: []
        }
      },
      filters: {
        clients: {
          criteria: null
        }
      },
      paginations: {
        clients: {
          totalRows: 0,
          currentPage: 1,
          perPage: 10
        }
      },
      client_id: null,
      row: []
    };
  },
  methods: {
    onDepartmentEntry() {
      if (this.entryMode == "Add") {
        //name of form
        //if from a modal?
        //name of table to be inserted
        this.createEntity("client", true, "clients");
      } else {
        //name of form
        //name of primary key
        //if from a modal?
        //row to be edited
        this.updateEntity("client", "client_id", true, this.row);
      }
    },
    onDepartmentDelete() {
      this.deleteEntity("client", this.client_id, true, "clients", "client_id");
    },
    async setDelete(data) {
      this.client_id = data.item.client_id;
      this.showModalDelete = true;
    },
    setUpdate(data) {
      this.row = data.item;
      this.resetFieldStates("client");
      this.fillEntityForm("client", data.item.client_id);
      this.showModalEntry = true;
      this.entryMode = "Edit";
    }
  },
  created() {
    //name of table
    // this.fillTableList("clients");

    this.$http

      .get("api/clients", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        this.tables.clients.items = response.data.clients;
        this.paginations.clients.totalRows = response.data.clients.length;
        this.options.departments.items = response.data.departments;
      })
      .catch(error => {
        console.log(error);
      });
  }
};
</script>

