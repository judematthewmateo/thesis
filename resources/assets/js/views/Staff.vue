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
label {
  font-size: 15px;
}
</style>

<template>
  <div class="animated fadeIn">
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
            <b-row class="mb-2">
              <!-- row button and search input -->
              <b-col sm="4">
                <!-- main card -->
                <h5 slot="header">
                  <!-- table header -->
                  <span class="text-primary">
                    <i class="fa fa-bars"></i>
                    Queue Report(s)
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
                  :items.sync="tables.reports.items"
                  :filter="filters.reports.criteria"
                >
                  <!-- table -->

                  <template v-slot:cell(show_details)="row">
                    <!-- action slot  :to="{path: 'products/' + data.item.id } -->
                    <b-button
                      variant="primary"
                      size="sm"
                      @click="row.toggleDetails(row)"
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
                            </b-col>
                          </b-row>
                          <!-- <b-col>{{ row.item.age }}</b-col> -->
                          <b-row class="mb-2">
                            <b-col>
                              <b>Reported by :</b>
                            </b-col>
                          </b-row>
                          <!-- <b-col>{{ row.item.isActive }}</b-col> -->
                          <b-row class="mb-2">
                            <b-col>
                              <b>Department :</b>
                            </b-col>
                          </b-row>
                          <!-- <b-col>{{ row.item.isActive }}</b-col> -->
                          <b-row class="mb-2">
                            <b-col>
                              <b-form-textarea placeholder="Remarks"></b-form-textarea>
                            </b-col>
                          </b-row>
                        </b-col>
                        <b-col lg="3">
                          <b-row class="mb-2">
                            <b-col>
                              <b>Kind of Problem :</b>
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
                              <b>What staff you need to do? :</b>
                            </b-col>
                          </b-row>
                        </b-col>
                        <b-col lg="3">
                          <br />
                          <br />
                          <br />
                          <b-button class="m-1" size="sm" variant="success">Accept this report</b-button>
                          <b-button
                            class="m-1"
                            size="sm"
                            variant="primary"
                          >Request to the Administrator</b-button>
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
  name: "staffs",
  data() {
    return {
      entryMode: "Add",
      //   showModalEntry: false,
      //   showModalDelete: false,
      forms: {
        staff: {
          isSaving: false,
          isDeleting: false,
          fields: {
            report_id: null
          }
        }
      },
      tables: {
        reports: {
          fields: [
            {
              key: "report_id",
              label: "Report No.",
              thStyle: { width: "150px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "report_by",
              label: "Report by",
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
              key: "send_datetime",
              label: "Send date/time",
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
      staff_id: null,
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
    }
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
      })
      .catch(error => {
        console.log(error);
      });
  }
};
</script>