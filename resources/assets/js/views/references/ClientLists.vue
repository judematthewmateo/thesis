<style scoped>
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  margin: 0;
}
</style>
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
                <b-button
                  variant="primary"
                  @click="showModalEntry = true, entryMode='Add', clearFields('client')"
                >
                  <i class="fa fa-plus-circle"></i> Create New Client Account
                </b-button>
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
          </b-card>
        </b-col>
      </b-row>
    </div>

    <b-modal
      v-model="showModalEntry"
      :noCloseOnEsc="true"
      :noCloseOnBackdrop="true"
      @shown="focusElement('id_number')"
    >
      <div slot="modal-title">
        <!-- modal title -->
        Creating New Client Account
      </div>

      <b-col lg="12">
        <!-- modal body -->
        <b-form @keydown="resetFieldStates('client')" autocomplete="off">
          <b-row>
            <b-col lg="6">
              <b-form-group>
                <label>
                  <i
                    class="icon-required fa fa-exclamation-circle"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Required Feild"
                  ></i> Account Number
                </label>
                <div class="input-group">
                  <span class="input-group-addon" placeholder="ID NO.">
                    <i class="icon-user-follow"></i>
                  </span>
                  <b-form-input
                    disabled
                    class="form-control"
                    placeholder="XXXX - OLFU - XXXX"
                    hover
                    title="Auto Generate"
                  />
                </div>
              </b-form-group>

              <b-form-group>
                <label for="id_number">
                  <i
                    class="icon-required fa fa-exclamation-circle"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Required Feild"
                  ></i> ID Number
                </label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-hashtag"></i>
                  </span>

                  <b-form-input
                    ref="id_number"
                    type="number"
                    class="form-control"
                    placeholder="ID NO."
                    v-model="forms.client.fields.id_number"
                  />
                </div>
              </b-form-group>
              <b-form-group>
                <label>
                  <i
                    class="icon-required fa fa-exclamation-circle"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Required Feild"
                  ></i> First Name
                </label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="icon-user"></i>
                  </span>
                  <b-form-input
                    type="text"
                    class="form-control"
                    placeholder="First Name"
                    v-model="forms.client.fields.firstname"
                  />
                </div>
              </b-form-group>
              <b-form-group>
                <label>Middle Name</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="icon-user"></i>
                  </span>
                  <b-form-input
                    type="text"
                    class="form-control"
                    placeholder="Middle Name"
                    v-model="forms.client.fields.middlename"
                  />
                </div>
              </b-form-group>
              <label>
                <i
                  class="icon-required fa fa-exclamation-circle"
                  data-toggle="tooltip"
                  data-placement="top"
                  title="Required Feild"
                ></i> Last Name
              </label>
              <b-form-group>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="icon-user"></i>
                  </span>
                  <b-form-input
                    type="text"
                    class="form-control"
                    placeholder="Last Name"
                    v-model="forms.client.fields.lastname"
                  />
                </div>
              </b-form-group>
            </b-col>

            <b-col lg="6">
              <b-form-group>
                <label>Contact Number</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="icon-user"></i>
                  </span>
                  <b-form-input
                    type="number"
                    class="form-control"
                    placeholder="Contact Number"
                    v-model="forms.client.fields.contact_number"
                  />
                </div>
              </b-form-group>

              <b-form-group>
                <label>
                  <i
                    class="icon-required fa fa-exclamation-circle"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Required Feild"
                  ></i> Select Department
                </label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="icon-home"></i>
                  </span>

                  <select2
                    class="js-example-responsive"
                    style="width: 80%"
                    ref="department_id"
                    :allowClear="false"
                    :placeholder="'Select Department'"
                    v-model="forms.client.fields.department_id"
                  >
                    <option
                      v-for="right in options.departments.items"
                      :key="right.department_id"
                      :value="right.department_id"
                    >{{right.department_name}}</option>
                  </select2>
                </div>
              </b-form-group>
              <b-form-group>
                <label>
                  <i
                    class="icon-required fa fa-exclamation-circle"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Required Feild"
                  ></i> Username
                </label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="icon-user"></i>
                  </span>
                  <b-form-input
                    type="text"
                    class="form-control"
                    placeholder="Username"
                    v-model="forms.client.fields.username"
                  />
                </div>
              </b-form-group>
              <b-form-group>
                <label>
                  <i
                    class="icon-required fa fa-exclamation-circle"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Required Feild"
                  ></i> Password
                </label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="icon-lock"></i>
                  </span>
                  <b-form-input
                    type="password"
                    class="form-control"
                    placeholder="Password"
                    v-model="forms.client.fields.password"
                  />
                </div>
              </b-form-group>
            </b-col>
          </b-row>
        </b-form>
      </b-col>
      <div slot="modal-footer">
        <!-- modal footer buttons -->
        <b-button :disabled="forms.client.isSaving" variant="primary" @click="onClientEntry">
          <icon v-if="forms.client.isSaving" name="sync" spin></icon>
          <i class="fa fa-check"></i>
          Save
        </b-button>
        <b-button variant="secondary" @click="showModalEntry=false">Close</b-button>
      </div>
    </b-modal>
    <b-modal v-model="showModalDelete" :noCloseOnEsc="true" :noCloseOnBackdrop="true">
      <div slot="modal-title">Delete Account</div>

      <b-col lg="12">Are you sure you want to Delete this Account?</b-col>
      <div slot="modal-footer">
        <b-button :disabled="forms.client.isSaving" variant="primary" @click="onClientDelete">
          <icon v-if="forms.client.isSaving" name="sync" spin></icon>
          <i class="fa fa-check"></i>
          OK
        </b-button>
        <b-button variant="secondary" @click="showModalDelete=false">Close</b-button>
      </div>
    </b-modal>
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
              key: "user_id",
              label: "User ID",
              thStyle: { width: "150px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "account_no",
              label: "Account Number",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "firstname",
              label: "First Name",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "lastname",
              label: "Last Name",
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
      options: {
        departments: {
          items: []
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
    onClientEntry() {
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
        this.updateEntity("client", "user_id", true, this.row);
      }
    },
    onClientDelete() {
      this.deleteEntity("client", this.user_id, true, "clients", "user_id");
    },
    async setDelete(data) {
      this.user_id = data.item.user_id;
      this.showModalDelete = true;
    },
    setUpdate(data) {
      this.row = data.item;
      this.resetFieldStates("client");
      this.fillEntityForm("client", data.item.user_id);
      this.showModalEntry = true;
      this.entryMode = "Edit";
    }
  },
  created() {
    //name of table
    // this.fillTableList("staffs");

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

