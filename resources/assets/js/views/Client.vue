<style scoped>
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
            <a class="nav-link" href="#">Setting</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" @click="logOutStaff()">Logout</a>
          </li>
        </ul>
      </div>
    </b-nav>

    <!-- main row -->

    <!-- <div class="mt-10">
          <label>Name :</label>
          <a>JUDE G. MATEO</a>
          <br />
          <label>Username :</label>
          <a>Admin</a>
          <br />
          <label>Department :</label>
          <a>IT Support</a>
    </div>-->

    <div style="overflow: hidden;">
      <div style="background-color: lightgray;">
        <b-row>
          <b-col sm="5">
            <div class="profile">
              <h5>JUDE G. MATEO</h5>

              <label>Username :</label>
              <a>Admin</a>
              <br />
              <label>Department :</label>
              <a>IT Support</a>
              <br />
              <label>User type :</label>
              <a>Staff</a>
            </div>
          </b-col>

          <b-col sm="2">
            <b-img
              class="mt-2"
              thumbnail
              fluid
              src="images/login/ccs.png"
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
                  variant="primary"
                  @click="showModalSendReport = true, entryMode='Add', clearFields('client')"
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
                  :fields="tables.reports.fields"
                  :items.sync="tables.reports.items"
                  :filter="filters.reports.criteria"
                >
                  <!-- table -->

                  <template v-slot:cell(show_details)="row">
                    <!-- action slot  :to="{path: 'products/' + data.item.id } -->
                    <b-button
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
                              <b>
                                Report No. :
                                {{row.item.report_id}}
                              </b>
                            </b-col>
                          </b-row>
                          <!-- <b-col>{{ row.item.age }}</b-col> -->
                          <b-row class="mb-2">
                            <b-col>
                              <b>Report Accept by :</b>
                            </b-col>
                          </b-row>
                          <!-- <b-col>{{ row.item.isActive }}</b-col> -->
                          <b-row class="mb-2">
                            <b-col>
                              <b>Department : {{row.item.department_name}}</b>
                            </b-col>
                          </b-row>
                          <!-- <b-col>{{ row.item.isActive }}</b-col> -->
                          <b-row class="mb-2">
                            <b-col></b-col>
                          </b-row>
                        </b-col>
                        <b-col lg="3">
                          <b-row class="mb-2">
                            <b-col>
                              <b>Problem issue : {{row.item.report_name}}</b>
                              <!-- <b-col>{{ row.item.isActive }}</b-col> -->
                            </b-col>
                          </b-row>
                          <b-row class="mb-2">
                            <b-col>
                              <b>What kind of Problem? :</b>
                            </b-col>
                          </b-row>
                          <!-- <b-col>{{ row.item.isActive }}</b-col> -->
                          <b-row class="mb-2">
                            <b-col>
                              <b-form-textarea
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
                          <b-button class="m-1" size="sm" variant="success">Rate the Staff</b-button>
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
      v-model="showModalSendReport"
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
        <b-form @keydown="resetFieldStates('client')" autocomplete="off">
          <!-- modal body -->
          <b-form-group>
            <label>Name your Report</label>
            <b-form-input
              ref="report_name"
              id="report_name"
              v-model="forms.client.fields.report_name"
              type="text"
              placeholder="Name your Report"
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
          </b-form-group>

          <b-form-group>
            <b-form-radio-group v-model="forms.client.fields.situation" name="radio-sub-component">
              <b-form-radio name="some-radios" value="1">Urgent</b-form-radio>
              <b-form-radio name="some-radios" value="0">Non-Urgent</b-form-radio>
            </b-form-radio-group>
          </b-form-group>
          <b-form-group>
            <b-form-textarea
              row="2"
              placeholder="Remarks"
              v-model="forms.client.fields.report_remarks"
            ></b-form-textarea>
          </b-form-group>
        </b-form>
      </b-col>

      <div slot="modal-footer">
        <!-- modal footer buttons -->
        <b-button :disabled="forms.client.isSaving" variant="primary" @click="SendReport">
          <icon v-if="forms.client.isSaving" name="sync" spin></icon>
          <i class="fa fa-check"></i>
          Send
        </b-button>
        <b-button variant="secondary" @click="showModalSendReport=false">Close</b-button>
      </div>
    </b-modal>
    <!-- <div class="footer-copyright text-center py-3">
      <footer id="sticky-footer" class="py-4 bg-dark text-white-50 mb-0">
        <div class="container text-center">
          <a style="font-size: 13px;">Copyright &copy; General Services</a>
        </div>
      </footer>
    </div>-->
  </div>
</template>
<script>
export default {
  name: "clients",
  data() {
    return {
      entryMode: "Add",
      showModalSendReport: false,
      //   showModalEntry: false,
      //   showModalDelete: false,
      forms: {
        client: {
          isSaving: false,
          isDeleting: false,
          fields: {
            report_id: null,
            report_name: null,
            situation: 0,
            report_remarks: null
          }
        }
      },
      tables: {
        reports: {
          fields: [
            {
              key: "report_id",
              label: "Report No.",
              thStyle: { width: "50px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "account_no",
              label: "Account Number",
              thStyle: { width: "150px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "firstname",
              label: "Send by",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "department_name",
              label: "From Department",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "send_datetime",
              label: "Send date/time",
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
        reports: {
          criteria: null
        }
      },
      options: {
        departments: {
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
    SendReport() {
      if (this.entryMode == "Add") {
        //name of form
        //if from a modal?
        //name of table to be inserted
        this.createEntity("client", true, "reports");
      } else {
        //name of form
        //name of primary key
        //if from a modal?
        //row to be edited
        this.updateEntity("client", "report_id", true, this.row);
      }
    }
    // GetReport(data) {
    //   var row = data.item;
    //   this.report_id = row.report_id;
    //   this.account_no = row.account_no;
    //   this.client_name = row.client_name;

    //   this.department_name = row.department_name;

    //   // this.$http
    //   //   .get("api/report/" + row.report_id, {
    //   //     headers: {
    //   //       Authorization: "Bearer " + localStorage.getItem("token")
    //   //     }
    //   //   })
    //   //   .then(response => {
    //   //     this.reports = response.data.data;
    //   //     this.reports.forEach(s => {
    //   //       s.is_selected = 0;
    //   //     });
    //   //   })
    //   //   .catch(error => {
    //   //     console.log(error);
    //   //   });
    //   // this.row.toggleDetails;
    // }
  },
  created() {
    this.$http
      .get("api/reports", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        this.tables.reports.items = response.data.reports;
        this.options.departments.items = response.data.departments;
      })
      .catch(error => {
        console.log(error);
      });
  }
};
</script>