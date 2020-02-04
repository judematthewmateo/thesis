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
                Staffs List
                <small
                  class="font-italic"
                >List of all registered Staffs .</small>
              </span>
            </h5>
            <b-row class="mb-2">
              <!-- row button and search input -->
              <b-col sm="4">
                <b-button
                  variant="primary"
                  @click="showModalEntry = true, entryMode='Add', clearFields('staff')"
                >
                  <i class="fa fa-plus-circle"></i> Create New Staff Account
                </b-button>
              </b-col>

              <b-col sm="4">
                <span></span>
              </b-col>

              <b-col sm="4">
                <b-form-input v-model="filters.staffs.criteria" type="text" placeholder="Search"></b-form-input>
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
                  :filter="filters.staffs.criteria"
                  :fields="tables.staffs.fields"
                  :items.sync="tables.staffs.items"
                  :current-page="paginations.staffs.currentPage"
                  :per-page="paginations.staffs.perPage"
                >
                  <!-- table -->

                  <template v-slot:cell(action)="data">
                    <b-button
                      class="button"
                      variant="primary"
                      size="sm"
                      @click="data.toggleDetails()"
                    >
                      <i class="fa fa-eye"></i>
                    </b-button>
                    <!-- action slot  :to="{path: 'departments/' + data.item.id } -->
                    <b-btn :size="'sm'" variant="primary" @click="setUpdate(data)">
                      <i class="fa fa-edit"></i>
                    </b-btn>

                    <b-btn
                      :size="'sm'"
                      :disabled="forms.staff.isDeleting"
                      variant="danger"
                      @click="setDelete(data)"
                    >
                      <icon v-if="forms.staff.isDeleting" name="sync" spin></icon>
                      <i v-else class="fa fa-trash"></i>
                    </b-btn>
                  </template>
                  <template v-slot:row-details="data">
                    <b-card>
                      <b-row>
                        <b-col lg="6">
                          <b-row class="mb-2">
                            <b-col>
                              <label>Account Number. :&emsp; {{data.item.account_no}}</label>
                            </b-col>
                          </b-row>
                          <b-row class="mb-2">
                            <b-col>
                              <label>ID NO. : &emsp; {{data.item.id_number}}</label>
                            </b-col>
                          </b-row>
                          <b-row class="mb-2">
                            <b-col>
                              <label>First Name : &emsp; {{data.item.firstname}}</label>
                            </b-col>
                          </b-row>
                          <b-row class="mb-2">
                            <b-col>
                              <label>Middle Name. : &emsp; {{data.item.middlename}}</label>
                            </b-col>
                          </b-row>
                          <b-row class="mb-2">
                            <b-col>
                              <label>Last Name : &emsp; {{data.item.lastname}}</label>
                            </b-col>
                          </b-row>
                        </b-col>
                        <b-col lg="3">
                          <b-row class="mb-2">
                            <b-col>
                              <label>User Type : &emsp; {{data.item.user_type_name}}</label>
                            </b-col>
                          </b-row>
                          <b-row class="mb-2">
                            <b-col>
                              <label>Department : &emsp; {{data.item.department_name}}</label>
                            </b-col>
                          </b-row>
                          <b-row class="mb-2">
                            <b-col>
                              <label>Contact NO. : &emsp; {{data.item.contact_number}}</label>
                            </b-col>
                          </b-row>
                          <b-row class="mb-2">
                            <b-col>
                              <label>Username : &emsp; {{data.item.username}}</label>
                            </b-col>
                          </b-row>
                        </b-col>
                      </b-row>
                    </b-card>
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
                  :total-rows="paginations.staffs.totalRows"
                  :per-page="paginations.staffs.perPage"
                  v-model="paginations.staffs.currentPage"
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

    <div></div>
    <b-modal
      v-model="showModalEntry"
      :noCloseOnEsc="true"
      :noCloseOnBackdrop="true"
      @shown="focusElement('id_number')"
    >
      <div slot="modal-title">
        <!-- modal title -->
        Creating New Staff Account
      </div>

      <b-col lg="12">
        <!-- modal body -->
        <b-form @keydown="resetFieldStates('staff')" autocomplete="off">
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
                    v-model="forms.staff.fields.id_number"
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
                    v-model="forms.staff.fields.firstname"
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
                    v-model="forms.staff.fields.middlename"
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
                    v-model="forms.staff.fields.lastname"
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
                    v-model="forms.staff.fields.contact_number"
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
                    v-model="forms.staff.fields.department_id"
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
                    v-model="forms.staff.fields.username"
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
                    v-model="forms.staff.fields.password"
                  />
                </div>
              </b-form-group>
            </b-col>
          </b-row>
        </b-form>
      </b-col>
      <div slot="modal-footer">
        <!-- modal footer buttons -->
        <b-button :disabled="forms.staff.isSaving" variant="primary" @click="onStaffEntry">
          <icon v-if="forms.staff.isSaving" name="sync" spin></icon>
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
        <b-button :disabled="forms.staff.isSaving" variant="primary" @click="onStaffDelete">
          <icon v-if="forms.staff.isSaving" name="sync" spin></icon>
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
  name: "staffs",
  data() {
    return {
      entryMode: "Add",
      showModalEntry: false, //if true show modal
      showModalDelete: false,
      forms: {
        staff: {
          isSaving: false,
          isDeleting: false,
          fields: {
            id_no: null,
            firstname: null,
            middlename: null,
            lastname: null,
            contact_number: null,
            department_id: null,
            username: null,
            password: null,
            user_type_id: 2
          }
        }
      },
      tables: {
        staffs: {
          fields: [
            // {
            //   key: "user_id",
            //   label: "User ID",
            //   thStyle: { width: "150px" },
            //   tdClass: "align-middle",
            //   sortable: true
            // },
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
              thStyle: { width: "120px" },
              tdClass: "text-center"
            }
          ],
          items: []
        }
      },
      filters: {
        staffs: {
          criteria: null
        }
      },
      options: {
        departments: {
          items: []
        }
      },
      paginations: {
        staffs: {
          totalRows: 0,
          currentPage: 1,
          perPage: 10
        }
      },
      user_id: null,

      row: []
    };
  },
  methods: {
    onStaffEntry() {
      if (this.entryMode == "Add") {
        //name of form
        //if from a modal?
        //name of table to be inserted
        this.createEntity("staff", true, "staffs");
      } else {
        //name of form
        //name of primary key
        //if from a modal?
        //row to be edited
        this.updateEntity("staff", "user_id", true, this.row);
      }
    },
    onStaffDelete() {
      this.deleteEntity("staff", this.user_id, true, "staffs", "user_id");
    },
    async setDelete(data) {
      this.user_id = data.item.user_id;
      this.showModalDelete = true;
    },
    setUpdate(data) {
      this.row = data.item;
      this.resetFieldStates("staff");
      this.fillEntityForm("staff", data.item.user_id);
      this.showModalEntry = true;
      this.entryMode = "Edit";
    }
  },
  created() {
    //name of table
    // this.fillTableList("staffs");

    this.$http

      .get("api/staffs", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        this.tables.staffs.items = response.data.staffs;
        this.paginations.staffs.totalRows = response.data.staffs.length;
        this.options.departments.items = response.data.departments;
      })
      .catch(error => {
        console.log(error);
      });
  }
};
</script>

