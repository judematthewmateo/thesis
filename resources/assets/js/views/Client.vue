<style scoped>
.button:hover {
  background-color: lightgray;
  color: black;
}
hr {
  display: block;
  margin-top: 0.5%;
  margin-left: auto;
  margin-right: auto;
  border-style: inset;
  border-width: 5px;
}
.profile {
  text-align: center;
  margin-top: 8%;
}
a {
  font-size: 20px;
}
</style>

<template scope>
  <div class="animated fadeIn">
    <notifications group="notification" />
    <b-nav extra-large class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">General Services</a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="/Staff">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">History log</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" @click="logOutStaff()">Logout</a>
          </li>
        </ul>
      </div>
    </b-nav>

    <div style="overflow: hidden;">
      <div style="background-color: lightgray;">
        <b-row>
          <b-col sm="5">
            <div class="profile">
              <h5>{{$store.state.user.firstname}} {{$store.state.user.lastname}}</h5>

              <label>Username : {{$store.state.user.username}}</label>

              <br />
              <label>Department :</label>
              <a>{{$store.state.user.department_name}}</a>
              <br />
              <label>User type :</label>
              <a>Client</a>
            </div>
          </b-col>

          <b-col sm="2">
            <b-img
              class="mt-2"
              thumbnail
              fluid
              src="images/login/login.jpg"
              rounded="circle"
              style="height:190; 
              weight:500px; 
              background-size: cover; 
              background-attachment: fixed;
              background-repeat: no-repeat;
              background-position: center;"
            ></b-img>
          </b-col>
          <b-col sm="5">
            <span></span>
          </b-col>
        </b-row>

        <hr />
      </div>

      <b-row>
        <!-- main row -->
        <b-col sm="12">
          <b-card class="ml-3 mr-3">
            <h5 slot="header">
              <!-- table header -->
              <span class="text-primary">
                <i class="fa fa-bars"></i>
                Report Lists
                <small class="font-italic">List of your reports .</small>
              </span>
            </h5>
            <b-row class="mb-2">
              <!-- row button and search input -->
              <b-col sm="4">
                <b-button
                  class="button"
                  variant="primary"
                  @click="showModalEntry = true, entryMode='Add', clearFields('clientreport')"
                >
                  <i class="fa fa-plus-circle"></i> Send New Report
                </b-button>
              </b-col>

              <b-col sm="4">
                <span></span>
              </b-col>

              <b-col sm="4">
                <b-form-input type="text" placeholder="Search"></b-form-input>
              </b-col>
            </b-row>
            <!-- row button and search input -->

            <b-row>
              <b-col sm="12">
                <!-- row table -->

                <b-table
                  responsive
                  striped
                  hover
                  small
                  bordered
                  show-empty
                  :fields="tables.queuereports.fields"
                  :items.sync="tables.queuereports.items"
                  :filter="filters.queuereports.criteria"
                >
                  <!-- table -->

                  <template v-slot:cell(show_details)="row">
                    <!-- action slot  :to="{path: 'products/' + data.item.id } -->
                    <b-button
                      class="button"
                      variant="primary"
                      size="sm"
                      @click="row.toggleDetails()"
                    >{{ row.detailsShowing ? 'Hide' : 'Show'}} Details</b-button>
                  </template>

                  <template v-slot:row-details="row">
                    <b-card>
                      <b-row class="mb-2">
                        <b-col lg="3">
                          <span></span>
                        </b-col>
                        <b-col lg="3">
                          <b-row class="mb-2">
                            <b-col>
                              <b>Report No. :</b>
                              <label>&emsp;{{row.item.report_id}}</label>
                            </b-col>
                          </b-row>

                          <b-row class="mb-2">
                            <b-col>
                              <b>Report Accept by : {{row.item.firstname}} {{row.item.lastname}}</b>
                            </b-col>
                          </b-row>

                          <b-row class="mb-2">
                            <b-col>
                              <b>Department : {{row.item.accept_department}}</b>
                            </b-col>
                          </b-row>
                          <b-row class="mb-2">
                            <b-col>
                              <b>Situation : {{row.item.situation_id}}</b>
                            </b-col>
                          </b-row>
                        </b-col>
                        <b-col lg="3">
                          <b-row class="mb-2">
                            <b-col>
                              <b>Name of Report : {{row.item.report_name}}</b>
                            </b-col>
                          </b-row>
                          <b-row class="mb-2">
                            <b-col>
                              <b>Department/Staff needed : {{row.item.need_department}}</b>
                            </b-col>
                          </b-row>

                          <b-row class="mb-2">
                            <b-col>
                              <b>Remarks :</b>
                              <b-form-textarea
                                style="background-color: white;"
                                disabled
                                v-model="row.item.report_remarks"
                                placeholder="Remarks"
                              ></b-form-textarea>
                            </b-col>
                          </b-row>
                        </b-col>

                        <b-col lg="3">
                          <br />
                          <br />
                          <br />

                          <b-button
                            class="button m-1"
                            size="sm"
                            variant="success"
                            @click="setUpdate(row)"
                          >Update this Report</b-button>
                          <b-button
                            class="button m-1"
                            size="sm"
                            variant="danger"
                            :disabled="forms.clientreport.isDeleting"
                            @click="setDelete(row)"
                          >
                            <icon v-if="forms.clientreport.isDeleting" name="sync" spin></icon>Cancel this Report
                          </b-button>
                        </b-col>
                      </b-row>
                    </b-card>
                  </template>
                </b-table>
                <!-- table -->
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
      @shown="focusElement('report_name')"
    >
      <div slot="modal-title">
        <!-- modal title -->
        Send Report
      </div>
      <!-- modal title -->

      <b-col lg="12">
        <!-- modal body -->
        <b-form @keydown="resetFieldStates('clientreport')" autocomplete="off">
          <!-- modal body -->
          <b-form-group>
            <label>
              <i
                class="icon-required fa fa-exclamation-circle"
                data-toggle="tooltip"
                data-placement="top"
                title="Required Feild"
              ></i> Name of Report
            </label>
            <b-form-input
              ref="report_name"
              id="report_name"
              v-model="forms.clientreport.fields.report_name"
              type="text"
              placeholder="Name of Report"
            ></b-form-input>
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
            <select2
              @input="getDepartmentInfo"
              ref="need_department"
              :allowClear="false"
              :placeholder="'Select Department'"
              v-model="forms.clientreport.fields.need_department"
            >
              <option
                v-for="right in options.departments.items"
                :key="right.department_id"
                :value="right.department_id"
              >{{right.department_name}}</option>
            </select2>
          </b-form-group>
          <b-form-group>
            <label>
              <i
                class="icon-required fa fa-exclamation-circle"
                data-toggle="tooltip"
                data-placement="top"
                title="Required Feild"
              ></i> Select type of Problem
            </label>
            <select2
              ref="what_part"
              :allowClear="false"
              :placeholder="'Select type of Problem'"
              v-model="forms.clientreport.fields.what_part"
            >
              <option
                v-for="right in options.filteredparts.items"
                :key="right.part_id"
                :value="right.part_id"
              >{{right.part_name}}</option>
            </select2>
          </b-form-group>

          <b-form-group>
            <b-form-radio-group
              v-model="forms.clientreport.fields.situation_id"
              name="radio-sub-component"
            >
              <b-form-radio name="some-radios" value="1">Urgent</b-form-radio>
              <b-form-radio name="some-radios" value="0">Non-Urgent</b-form-radio>
            </b-form-radio-group>
          </b-form-group>
          <b-form-group>
            <b-form-textarea
              row="2"
              placeholder="Remarks"
              v-model="forms.clientreport.fields.report_remarks"
            ></b-form-textarea>
          </b-form-group>
        </b-form>
      </b-col>

      <div slot="modal-footer">
        <!-- modal footer buttons -->
        <b-button
          class="button"
          :disabled="forms.clientreport.isSaving"
          variant="primary"
          @click="onClientReportEntry"
        >
          <icon v-if="forms.clientreport.isSaving" name="sync" spin></icon>
          <i class="fa fa-check"></i>
          Send
        </b-button>
        <b-button class="button" variant="secondary" @click="showModalEntry=false">Close</b-button>
      </div>
    </b-modal>

    <b-modal v-model="showModalDelete" :noCloseOnEsc="true" :noCloseOnBackdrop="true">
      <div slot="modal-title">Cancel this Report</div>

      <b-col lg="12">Are you sure you want to Cancel this Report?</b-col>
      <div slot="modal-footer">
        <b-button
          class="button"
          :disabled="forms.clientreport.isSaving"
          variant="primary"
          @click="onReportDelete"
        >
          <icon v-if="forms.clientreport.isSaving" name="sync" spin></icon>
          <i class="fa fa-check"></i>
          OK
        </b-button>
        <b-button class="button" variant="secondary" @click="showModalDelete=false">Close</b-button>
      </div>
    </b-modal>
  </div>
</template>
<script>
export default {
  name: "clientreports",
  data() {
    return {
      entryMode: "Add",
      showModalEntry: false,
      //   showModalEntry: false,
      showModalDelete: false,
      forms: {
        clientreport: {
          isSaving: false,
          isDeleting: false,
          fields: {
            report_id: null,
            report_name: null,
            situation_id: 0,
            report_remarks: null
          }
        }
      },
      tables: {
        queuereports: {
          fields: [
            {
              key: "report_id",
              label: "Report No.",
              thStyle: { width: "80px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "account_no",
              label: "Account Number",
              thStyle: { width: "150px" },
              tdClass: "align-middle"
            },
            {
              key: "firstname",
              label: "Send by",
              tdClass: "align-middle"
            },
            {
              key: "department_name",
              label: "From Department",
              tdClass: "align-middle"
            },
            {
              key: "send_datetime",
              label: "Send date/time",
              tdClass: "align-middle",
              sortable: true,
              formatter: value => {
                return this.moment(value, "MMMM DD, YYYY hh:mm A");
              }
            },
            {
              key: "status_name",
              label: "Status",
              tdClass: "align-middle",
              sortable: true
            },

            {
              key: "show_details",
              label: "",
              thStyle: { width: "170px" },
              tdClass: "text-center"
            }
          ],
          items: []
        }
      },
      filters: {
        queuereports: {
          criteria: null
        }
      },
      paginations: {
        queuereports: {
          totalRows: 0,
          currentPage: 1,
          perPage: 10
        }
      },
      options: {
        departments: {
          items: []
        },
        parts: {
          items: []
        },
        filteredparts: {
          items: []
        }
      },
      user_id: null,
      report_id: null,
      row: []
    };
  },

  methods: {
    logOutStaff() {
      if (localStorage.token) {
        this.$http
          .get("api/auth/logout", {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(response => {
            localStorage.removeItem("token");
            this.$store.commit("logoutUser");
            this.$router.push({ name: "Login" });
          })
          .catch(err => {
            console.log(err);
          });
      }
    },
    onClientReportEntry() {
      if (this.entryMode == "Add") {
        //name of form
        //if from a modal?
        //name of table to be inserted
        this.createEntity("clientreport", true, "queuereports");
      } else {
        //name of form
        //name of primary key
        //if from a modal?
        //row to be edited
        this.updateEntity("clientreport", "report_id", true, this.row);
      }
    },
    onReportDelete() {
      // this.deleteEntity(
      //   "clientreport",
      //   this.report_id,
      //   true,
      //   "queuereports",
      //   "report_id"
      // );
      this.forms.clientreport.isSaving = true;
      this.$http
        .put(
          "api/clientreport/delete/" + this.report_id,
          this.forms.clientreport.fields,
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          }
        )
        .then(response => {
          this.forms.clientreport.isSaving = false;
          this.$notify({
            type: "success",
            group: "notification",
            title: "Success!",
            text: "The report has been Cancelled."
          });

          const index = this.tables.queuereports.items.findIndex(
            item => item["report_id"] === response.data.data["report_id"]
          );

          this.$delete(this.tables.queuereports.items, index);
          this.paginations.queuereports.totalRows--;

          this.showModalDelete = false;
        })
        .catch(error => {
          this.forms.clientreport.isSaving = false;
          if (!error.response) return;
          const errors = error.response.data.errors;
          console.log(errors);
        });
    },

    async setDelete(row) {
      this.report_id = row.item.report_id;
      this.showModalDelete = true;
    },
    setUpdate(row) {
      this.row = row.item;
      this.resetFieldStates("clientreport");
      this.fillEntityForm("clientreport", row.item.report_id);
      this.showModalEntry = true;
      this.entryMode = "Edit";
    },
    getDepartmentInfo: function(value, data) {
      if (data.length > 0) {
        this.options.filteredparts.items = this.options.parts.items.filter(
          p => p.department_id == value
        );
      }
    }
  },
  created() {
    this.$http
      .get("api/clientreports", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        this.tables.queuereports.items = response.data.reports;
        this.options.departments.items = response.data.departments;
        this.options.parts.items = response.data.parts;
      })
      .catch(error => {
        console.log(error);
      });
  }
};
</script>