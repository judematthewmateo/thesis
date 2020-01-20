

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
                <!-- <b-button
                  variant="primary"
                  @click="showModalEntry = true, entryMode='Add', clearFields('staff')"
                >
                  <i class="fa fa-plus-circle"></i> Create New Departments
                </b-button>-->
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

    <div>
      <!-- modal div -->
    </div>
    <!-- modal div -->
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
          fields: {}
        }
      },
      tables: {
        staffs: {
          fields: [
            {
              key: "staff_id",
              label: "Staff ID",
              thStyle: { width: "150px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "staff_name",
              label: "Staff Name",
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
        staffs: {
          criteria: null
        }
      },
      paginations: {
        staffs: {
          totalRows: 0,
          currentPage: 1,
          perPage: 10
        }
      },
      staff_id: null,
      row: []
    };
  },
  methods: {
    onDepartmentEntry() {
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
        this.updateEntity("staff", "staff_id", true, this.row);
      }
    },
    onDepartmentDelete() {
      this.deleteEntity("staff", this.staff_id, true, "staffs", "staff_id");
    },
    async setDelete(data) {
      this.staff_id = data.item.staff_id;
      this.showModalDelete = true;
    },
    setUpdate(data) {
      this.row = data.item;
      this.resetFieldStates("staff");
      this.fillEntityForm("staff", data.item.staff_id);
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

