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

.rate {
  float: left;
  height: 60px;
  padding: 0 14px;
}
.rate:not(:checked) > input {
  position: absolute;
  top: -9999px;
}
.rate:not(:checked) > label {
  float: right;
  width: 1em;
  overflow: hidden;
  white-space: nowrap;
  cursor: pointer;
  font-size: 48px;
  color: #ccc;
}
.rate:not(:checked) > label:before {
  content: "★ ";
}
.rate > input:checked ~ label {
  color: #ffc700;
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
  color: #deb217;
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
  color: #c59b08;
}
</style>

<template scope>
  <div class="animated fadeIn">
    <notifications group="notification" />
    <b-nav extra-large class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" style="color: lightgreen;">General Services</a>
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
            <a class="nav-link" type="button" @click="showEntry=false">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" type="button" @click="showEntry=true">History log</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" @click="logOutStaff()" type="button">Logout</a>
          </li>
        </ul>
      </div>
    </b-nav>

    <div style="overflow: hidden;">
      <div style="background-color: lightgray;">
        <b-row>
          <b-col lg="3">
            <img src="images/olfulogo1.png" style="width:70%; hieght:70px; margin-left: 47%;" />
          </b-col>
          <b-col lg="5">
            <center>
              <h3 class="mt-5 ml-10">{{$store.state.user.firstname}} {{$store.state.user.lastname}}</h3>

              <label>Username :</label>
              <a>{{$store.state.user.username}}</a>
              <br />
              <label>Department :</label>
              <a>{{$store.state.user.department_name}}</a>
              <br />
              <label>User type : {{$store.state.user.user_type_name}}</label>
            </center>
          </b-col>
          <b-col lg="4">
            <img src="images/iserve.png" style="width:50%; hieght:50px;" />
          </b-col>
        </b-row>

        <hr />
      </div>
      <div v-show="!showEntry" class="animated fadeIn">
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
                      >
                        <i class="fa fa-eye"></i>
                        {{ row.detailsShowing ? 'Hide' : 'Show'}} Details
                      </b-button>
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
                            <b-row>
                              <b-button
                                class="button m-1"
                                variant="success"
                                style="width:45%;"
                                @click="showModalRating=true"
                                v-show="row.item.status_id == 2"
                              >
                                <i class="fa fa-star"></i> Rate the Service
                              </b-button>
                            </b-row>
                            <b-row>
                              <b-button
                                v-show="row.item.status_id == 0"
                                style="width:45%;"
                                class="button m-1"
                                variant="success"
                                @click="setUpdate(row)"
                              >
                                <i class="fa fa-edit"></i> Update this Report
                              </b-button>
                            </b-row>
                            <b-row>
                              <b-button
                                style="width:45%;"
                                class="button m-1"
                                variant="danger"
                                :disabled="forms.clientreport.isDeleting"
                                @click="setDelete(row)"
                                v-show="row.item.status_id == 0"
                              >
                                <icon v-if="forms.clientreport.isDeleting" name="sync" spin></icon>
                                <i class="fa fa-times"></i> Cancel this Report
                              </b-button>
                            </b-row>
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
            <label>Target Date</label>
            <date-picker
              v-model="forms.clientreport.fields.target_date"
              id="target_date"
              format="MMMM/DD/YYYY"
              type="date"
              lang="en"
              input-class="form-control mx-input"
              ref="target_date"
              :clearable="false"
              placeholder="Select Target Date"
            ></date-picker>
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
    <div v-show="showEntry" class="animated fadeIn">
      <b-card class="m-0">
        <h5 slot="header">
          <!-- table header -->
          <span class="text-primary">
            <i class="fa fa-bars"></i>
            History Log
            <small class="font-italic">List of all reports .</small>
          </span>
        </h5>
        <b-row class="mb-2">
          <!-- row button and search input -->

          <b-col sm="3">
            <b-button
              @click="previewReport()"
              class="mt-4 btn-success"
              style="float-center; width:100%; height: 30px"
            >
              <i class="fa fa-print"></i> Print Report
            </b-button>
          </b-col>

          <b-col sm="3">
            <label>From Done Date</label>
            <date-picker
              id="from_datetime"
              format="MMMM/DD/YYYY"
              type="date"
              lang="en"
              input-class="form-control mx-input"
              ref="from_datetime"
              :clearable="false"
              v-model="from_datetime"
            ></date-picker>
          </b-col>

          <b-col sm="3">
            <label>To Done Date</label>
            <date-picker
              id="to_datetime"
              format="MMMM/DD/YYYY"
              type="date"
              lang="en"
              input-class="form-control mx-input"
              ref="to_datetime"
              :clearable="false"
              v-model="to_datetime"
            ></date-picker>
          </b-col>
          <b-col sm="3">
            <b-form-input class="mt-4" type="text" placeholder="Search"></b-form-input>
          </b-col>
        </b-row>
        <b-table
          responsive
          striped
          hover
          small
          bordered
          show-empty
          :fields="tables.reportlogs.fields"
          :items="filterReports"
        ></b-table>
      </b-card>
    </div>
    <b-modal v-model="showModalRating" :noCloseOnEsc="true" :noCloseOnBackdrop="true" size="sm">
      <div slot="modal-title">
        Please Rate
        <i class="fa fa-smile-o" aria-hidden="true"></i>
      </div>
      <div class="rate">
        <input type="radio" id="star5" name="rate" value="5" />
        <label for="star5">5 stars</label>
        <input type="radio" id="star4" name="rate" value="4" />
        <label for="star4">4 stars</label>
        <input type="radio" id="star3" name="rate" value="3" />
        <label for="star3">3 stars</label>
        <input type="radio" id="star2" name="rate" value="2" />
        <label for="star2">2 stars</label>
        <input type="radio" id="star1" name="rate" value="1" />
        <label for="star1">1 star</label>
      </div>
      <div slot="modal-footer">
        <!-- modal footer buttons -->
        <b-button variant="primary" @click="AddRating">
          <i class="fa fa-check"></i>
          Submit
        </b-button>
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
      showEntry: false,
      showModalDelete: false,
      showModalRating: false,
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
              key: "target_datetime",
              label: "Target Date",
              tdClass: "align-middle",
              sortable: true,
              formatter: value => {
                if (value != null) {
                  return this.moment(value, "MMMM DD, YYYY");
                }
              }
            },
            {
              key: "status_name",
              label: "Status",
              tdClass: "align-middle"
            },

            {
              key: "show_details",
              label: "",
              thStyle: { width: "170px" },
              tdClass: "text-center"
            }
          ],
          items: []
        },
        reportlogs: {
          fields: [
            {
              key: "report_id",
              label: "Report No.",
              thStyle: { width: "80px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "report_name",
              label: "Name of Report",
              thStyle: { width: "150px" },
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
              key: "done_datetime",
              label: "Done date/time",
              tdClass: "align-middle",
              sortable: true,
              formatter: value => {
                if (value != null) {
                  return this.moment(value, "MMMM DD, YYYY hh:mm A");
                }
              }
            },
            {
              key: "firstname",
              label: "Staff Name",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "status_name",
              label: "Status",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "situation_name",
              label: "Situation",
              tdClass: "align-middle",
              sortable: true
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
      from_datetime: null,
      to_datetime: null,
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
    AddRating() {
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
    },
    previewReport() {
      var date_from = 0;
      var date_to = 0;
      if (this.from_datetime != null && this.to_datetime != null) {
        date_from = this.moment(this.from_datetime, "YYYY-MM-DD");
        date_to = this.moment(this.to_datetime, "YYYY-MM-DD");
      }
      window.open(
        "api/reports/clientreportlogs/" +
          date_from +
          "/" +
          date_to +
          "/" +
          this.$store.state.user.user_id
      );
    }
  },
  computed: {
    filterReports() {
      if (this.from_datetime != null && this.to_datetime != null) {
        return this.tables.reportlogs.items.filter(
          d =>
            this.moment(d.send_datetime, "YYYY-MM-DD") >=
              this.moment(this.from_datetime, "YYYY-MM-DD") &&
            this.moment(d.send_datetime, "YYYY-MM-DD") <=
              this.moment(this.to_datetime, "YYYY-MM-DD")
        );
      } else {
        return this.tables.reportlogs.items;
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
        this.tables.reportlogs.items = response.data.reportlogs;
        this.options.departments.items = response.data.departments;
        this.options.parts.items = response.data.parts;
      })
      .catch(error => {
        console.log(error);
      });
  }
};
</script>