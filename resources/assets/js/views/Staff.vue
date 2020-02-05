<style scoped>
.button:hover {
  background-color: lightgrey;
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
label {
  font-size: 15px;
}
</style>

<template>
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
        <span class="navbar-toggler-icon" style="color:white"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" @click="showEntry=false" type="button">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" @click="showEntry=true" type="button">History log</a>
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
          <b-col sm="5">
            <div class="profile">
              <h5>{{$store.state.user.firstname}} {{$store.state.user.lastname}}</h5>

              <label>Username :</label>
              <a>{{$store.state.user.username}}</a>
              <br />
              <label>Department :</label>
              <a>{{$store.state.user.department_name}}</a>
              <br />
              <label>User type :</label>
              <a>Staff</a>
            </div>
          </b-col>

          <b-col sm="2">
            <!-- <b-img
              class="mt-2"
              thumbnail
              fluid
              src="images/login/login.jpg"
              rounded="circle"
              style="height:150px; 
              weight:500px; 
              background-size: cover; 
              background-attachment: fixed;
              background-repeat: no-repeat;
              background-position: center;"
            ></b-img>-->
          </b-col>
          <b-col sm="5">
            <span></span>
          </b-col>
        </b-row>

        <hr />
      </div>
      <div v-show="!showEntry" class="animated fadeIn">
        <b-row>
          <!-- main row -->
          <b-col lg="6">
            <b-card class="ml-3 mr-0">
              <b-row class="mb-2">
                <!-- row button and search input -->
                <b-col sm="4">
                  <!-- main card -->
                  <h5 slot="header">
                    <!-- table header -->
                    <span class="text-primary">
                      <i class="fa fa-bars"></i>
                      Pending Report(s)
                    </span>
                  </h5>
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
                    :fields="tables.reports.fields"
                    :items="filterReports(0)"
                    :filter="filters.reports.criteria"
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
                          <b-col lg="8">
                            <b-row class="mb-2">
                              <b-col>
                                <b>Report No. :</b>
                                <label>&emsp;{{row.item.report_id}}</label>
                              </b-col>
                            </b-row>
                            <!-- <b-col>{{ row.item.age }}</b-col> -->
                            <b-row class="mb-2">
                              <b-col>
                                <b>
                                  Name of Report :
                                  <label>{{row.item.report_name}}</label>
                                </b>
                              </b-col>
                            </b-row>
                            <!-- <b-col>{{ row.item.isActive }}</b-col> -->
                            <b-row class="mb-2">
                              <b-col>
                                <b>Department/Staff needed :</b>
                              </b-col>
                            </b-row>
                            <!-- </b-col>
                            <b-col lg="6">-->
                            <b-row class="mb-2">
                              <b-col>
                                <b>Type of Problem :</b>
                              </b-col>
                            </b-row>

                            <b-row class="mb-2">
                              <b-col>
                                <b>Remarks :</b>
                                <b-form-textarea
                                  style="background-color: white; width: 60%;"
                                  disabled
                                  v-model="row.item.report_remarks"
                                  placeholder="Remarks"
                                ></b-form-textarea>
                              </b-col>
                            </b-row>
                          </b-col>
                          <b-col lg="4">
                            <h3>{{row.item.situation_name}}</h3>
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />
                            <br />

                            <b-button
                              class="button"
                              style="float:right; margin-top:8px;"
                              size="sm"
                              variant="success"
                              @click="AcceptReport(row)"
                            >
                              <i class="fa fa-thumbs-o-up"></i> Accept this Report
                            </b-button>
                          </b-col>
                          <!-- <b-button
                            class="m-1"
                            size="sm"
                            variant="danger"
                          >Request this Report to the Administrator</b-button>-->
                          <!-- </b-col> -->
                        </b-row>
                      </b-card>
                    </template>
                  </b-table>
                  <!-- table -->
                </b-col>
              </b-row>
            </b-card>
          </b-col>

          <b-col lg="6">
            <b-card class="mr-3 ml-0">
              <b-row class="mb-2">
                <!-- row button and search input -->
                <b-col sm="4">
                  <!-- main card -->
                  <h5 slot="header">
                    <!-- table header -->
                    <span class="text-primary">
                      <i class="fa fa-bars"></i>
                      Accepted Report(s)
                    </span>
                  </h5>
                </b-col>

                <b-col sm="4">
                  <span></span>
                </b-col>

                <b-col sm="4">
                  <b-form-input type="text" placeholder="Search"></b-form-input>
                </b-col>
              </b-row>
              <b-table
                responsive
                striped
                hover
                small
                bordered
                show-empty
                :fields="tables.reports.fields"
                :items="filterReports(1)"
                :filter="filters.reports.criteria"
              >
                <template v-slot:cell(show_details)="row">
                  <!-- action slot  :to="{path: 'products/' + data.item.id } -->
                  <b-button class="button" variant="primary" size="sm" @click="row.toggleDetails()">
                    <i class="fa fa-eye"></i>
                    {{ row.detailsShowing ? 'Hide' : 'Show'}} Details
                  </b-button>
                </template>

                <template v-slot:row-details="row">
                  <b-card>
                    <b-row class="mb-2">
                      <b-col lg="8">
                        <b-row class="mb-2">
                          <b-col>
                            <b>Report No. :</b>
                            <label>&emsp;{{row.item.report_id}}</label>
                          </b-col>
                        </b-row>
                        <!-- <b-col>{{ row.item.age }}</b-col> -->
                        <b-row class="mb-2">
                          <b-col>
                            <b>Name of Report : {{row.item.report_name}}</b>
                          </b-col>
                        </b-row>
                        <!-- <b-col>{{ row.item.isActive }}</b-col> -->
                        <b-row class="mb-2">
                          <b-col>
                            <b>Department/Staff needed :</b>
                          </b-col>
                        </b-row>
                        <!-- </b-col>
                        <b-col lg="6">-->
                        <b-row class="mb-2">
                          <b-col>
                            <b>Type of Problem :</b>
                          </b-col>
                        </b-row>

                        <b-row class="mb-2">
                          <b-col>
                            <b>Remarks :</b>
                            <b-form-textarea
                              style="background-color: white; width: 60%;"
                              disabled
                              v-model="row.item.report_remarks"
                              placeholder="Remarks"
                            ></b-form-textarea>
                          </b-col>
                        </b-row>
                      </b-col>
                      <b-col lg="4">
                        <h3>{{row.item.situation_name}}</h3>
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />

                        <b-button
                          class="button"
                          style="float:right; width: 80%; margin-top: 8px;"
                          size="sm"
                          variant="success"
                          @click="MarkDone(row)"
                        >
                          <i class="fa fa-check"></i> Done
                        </b-button>
                      </b-col>
                      <!-- <b-button
                            class="m-1"
                            size="sm"
                            variant="danger"
                      >Request this Report to the Administrator</b-button>-->
                      <!-- </b-col> -->
                    </b-row>
                  </b-card>
                </template>
              </b-table>
            </b-card>
          </b-col>
        </b-row>
      </div>
    </div>
    <b-modal v-model="showModalAcceptReport" :noCloseOnEsc="true" :noCloseOnBackdrop="true">
      <div slot="modal-title">Accept Report?</div>

      <b-col lg="12">Are you sure you want to Accept this Report?</b-col>
      <div slot="modal-footer">
        <b-button
          class="button"
          :disabled="forms.staff.isSaving"
          variant="primary"
          @click="onAcceptingReport"
        >
          <icon v-if="forms.staff.isSaving" name="sync" spin></icon>
          <i class="fa fa-check"></i>
          I will Accept
        </b-button>
        <b-button class="button" variant="secondary" @click="showModalAcceptReport=false">Close</b-button>
      </div>
    </b-modal>

    <b-modal v-model="showModalMarkdone" :noCloseOnEsc="true" :noCloseOnBackdrop="true">
      <div slot="modal-title">Done?</div>

      <b-col lg="12">Are you sure you want to Mark this Report as Done?</b-col>
      <div slot="modal-footer">
        <b-button
          class="button"
          :disabled="forms.staff.isSaving"
          variant="primary"
          @click="onMarkdoneReport"
        >
          <icon v-if="forms.staff.isSaving" name="sync" spin></icon>
          <i class="fa fa-check"></i>
          Yes
        </b-button>
        <b-button class="button" variant="secondary" @click="showModalMarkdone=false">No</b-button>
      </div>
    </b-modal>
    <div v-show="showEntry" class="animated fadeIn">
      <b-card class="m-0">
        <h5 slot="header">
          <!-- table header -->
          <span class="text-primary">
            <i class="fa fa-bars"></i>
            Report Lists
            <small class="font-italic">List of all reports .</small>
          </span>
        </h5>
        <b-row class="mb-2">
          <!-- row button and search input -->

          <b-col sm="3">
            <b-form-input class="mt-4" type="text" placeholder="Search"></b-form-input>
          </b-col>
          <b-col sm="3">
            <span></span>
          </b-col>

          <b-col sm="3">
            <label>From Date</label>
            <date-picker
              id="from_datetime"
              format="MMMM/DD/YYYY"
              type="date"
              lang="en"
              input-class="form-control mx-input"
              ref="from_datetime"
              :clearable="false"
            ></date-picker>
          </b-col>

          <b-col sm="3">
            <label>To Date</label>
            <date-picker
              id="to_datetime"
              format="MMMM/DD/YYYY"
              type="date"
              lang="en"
              input-class="form-control mx-input"
              ref="to_datetime"
              :clearable="false"
            ></date-picker>
          </b-col>
        </b-row>
        <b-table
          responsive
          striped
          hover
          small
          bordered
          show-empty
          :fields="tables.staffreportlogs.fields"
          :items.sync="tables.staffreportlogs.items"
        ></b-table>
        <b-button class="m-1 btn-success" style="float-right">
          <i class="fa fa-print"></i> Print Report
        </b-button>
      </b-card>
    </div>
  </div>
</template>
<script>
export default {
  name: "staffs",
  data() {
    return {
      entryMode: "Add",
      showModalEntry: false,
      showEntry: false,
      showModalAcceptReport: false,
      showModalMarkdone: false,
      forms: {
        staff: {
          isSaving: false,
          isDeleting: false,
          fields: {
            report_id: null,
            account_no: null,
            client_name: null,
            department_name: null,
            send_datetime: null
          }
        }
      },
      tables: {
        reports: {
          fields: [
            {
              key: "report_id",
              label: "Report No.",
              // thStyle: { width: "150px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "account_no",
              label: "Account Number",
              thStyle: { width: "120px" },
              tdClass: "align-middle"
            },
            {
              key: "firstname",
              label: "Reported by",
              tdClass: "align-middle"
            },
            {
              key: "department_name",
              label: "Department",
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
              key: "show_details",
              label: "",
              thStyle: { width: "100px" },
              tdClass: "text-center"
            }
          ],
          items: []
        },
        staffreportlogs: {
          fields: [
            {
              key: "report_id",
              label: "Report No.",
              tdClass: "align-middle",
              sortable: true
            }
          ]
        }
      },
      filters: {
        reports: {
          criteria: null
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
    filterReports(status_id) {
      return this.tables.reports.items.filter(r => r.status_id == status_id);
    },
    onAcceptingReport() {
      this.forms.staff.isSaving = true;
      this.$http
        .put(
          "api/staffaccept/delete/" + this.report_id,
          this.forms.staff.fields,
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          }
        )
        .then(response => {
          this.forms.staff.isSaving = false;
          this.$notify({
            type: "success",
            group: "notification",
            title: "Success!",
            text: "The report has been Accepted."
          });

          const index = this.tables.reports.items.findIndex(
            item => item["report_id"] === response.data.data["report_id"]
          );

          this.$delete(this.tables.reports.items, index);
          // this.paginations.queuereports.totalRows--;

          this.showModalAcceptReport = false;
        })
        .catch(error => {
          this.forms.staff.isSaving = false;
          if (!error.response) return;
          const errors = error.response.data.errors;
          console.log(errors);
        });
    },

    onMarkdoneReport() {
      // this.deleteEntity(
      //   "staffmarkdone",
      //   this.report_id,
      //   true,
      //   "reports",
      //   "report_id"
      // );
      this.forms.staff.isSaving = true;
      this.$http
        .put(
          "api/staffmarkdone/delete/" + this.report_id,
          this.forms.staff.fields,
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          }
        )
        .then(response => {
          this.forms.staff.isSaving = false;
          this.$notify({
            type: "success",
            group: "notification",
            title: "Success!",
            text: "The report has been done."
          });

          const index = this.tables.reports.items.findIndex(
            item => item["report_id"] === response.data.data["report_id"]
          );

          this.$delete(this.tables.reports.items, index);

          this.showModalMarkdone = false;
        })
        .catch(error => {
          this.forms.staff.isSaving = false;
          if (!error.response) return;
          const errors = error.response.data.errors;
          console.log(errors);
        });
    },

    async AcceptReport(row) {
      this.report_id = row.item.report_id;
      this.showModalAcceptReport = true;
    },
    async MarkDone(row) {
      this.report_id = row.item.report_id;
      this.showModalMarkdone = true;
    }
  },
  created() {
    this.$http
      .get("api/staffreports", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        this.tables.reports.items = response.data.reports;
      })
      .catch(error => {
        console.log(error);
      });
  }
};
</script>