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
  <div class="animated fadeIn" style="overflow: hidden;">
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
    </div>
    <div>
      <div class="animated fadeIn">
        <b-row>
          <!-- main row -->
          <b-col sm="12">
            <b-card class="ml-3 mr-3">
              <!-- main card -->
              <h5 slot="header">
                <!-- table header -->
                <span class="text-primary">
                  <i class="fa fa-bars"></i>
                  Report List
                  <small
                    class="font-italic"
                  >List of all report you send .</small>
                </span>
              </h5>
              <b-row class="mb-2">
                <!-- row button and search input -->
                <b-col sm="4">
                  <b-button
                    variant="primary"
                    @click="showModalReport = true, entryMode='Add', clearFields('client')"
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
                <!-- row table -->
                <b-col sm="12">
                  <b-table responsive striped hover small bordered show-empty>
                    <!-- table -->

                    <template v-slot:cell(action)="data">
                      <!-- action slot  :to="{path: 'departments/' + data.item.id } -->
                      <b-btn :size="'sm'" variant="primary">
                        <i class="fa fa-edit"></i>
                      </b-btn>

                      <b-btn :size="'sm'" variant="danger">
                        <icon name="sync" spin></icon>
                        <i class="fa fa-trash"></i>
                      </b-btn>
                    </template>
                  </b-table>
                  <!-- table -->
                </b-col>
              </b-row>
              <!-- row table -->
            </b-card>
            <!-- main card -->
          </b-col>
        </b-row>
      </div>
      <div>
        <!-- modal div -->
        <b-modal
          v-model="showModalReport"
          :noCloseOnEsc="true"
          :noCloseOnBackdrop="true"
          @shown="focusElement('report_name')"
        >
          <div slot="modal-title">
            <!-- modal title -->
          </div>
          <!-- modal title -->

          <b-col lg="12">
            <!-- modal body -->
          </b-col>

          <div slot="modal-footer">
            <!-- modal footer buttons -->
            <b-button
              :disabled="forms.client.isSaving"
              variant="primary"
              @click="onDepartmentEntry"
            >
              <icon v-if="forms.client.isSaving" name="sync" spin></icon>
              <i class="fa fa-check"></i>
              Send
            </b-button>
            <b-button variant="secondary" @click="showModalReport=false">Close</b-button>
          </div>
          <!-- modal footer buttons -->
        </b-modal>
        <b-modal v-model="showModalDelete" :noCloseOnEsc="true" :noCloseOnBackdrop="true">
          <div slot="modal-title">Report Cancel</div>

          <b-col lg="12">Are you sure you want to Cancel this report?</b-col>
          <div slot="modal-footer">
            <b-button
              :disabled="forms.client.isSaving"
              variant="primary"
              @click="onDepartmentDelete"
            >
              <icon v-if="forms.client.isSaving" name="sync" spin></icon>
              <i class="fa fa-check"></i>
              OK
            </b-button>
            <b-button variant="secondary" @click="showModalDelete=false">Close</b-button>
          </div>
        </b-modal>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "clients",
  data() {
    return {
      entryMode: "Add",
      showModalReport: false,
      //   showModalDelete: false,
      forms: {
        client: {
          fields: {
            report_id: null
          }
        }
      }
    };
  }
};
</script>