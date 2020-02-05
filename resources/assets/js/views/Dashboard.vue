<template>
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-6 col-lg-3">
        <b-card class="bg-primary" :no-block="true">
          <div class="card-body pb-0">
            <h4 class="mb-0">{{tables.dashboards.items.length}}</h4>
            <p>All Report(s)</p>
          </div>
          <card-line1-chart-example class="chart-wrapper px-3" style="height:70px;" height="70" />
        </b-card>
      </div>
      <!--/.col-->
      <div class="col-sm-6 col-lg-3">
        <b-card class="bg-success" :no-block="true">
          <div class="card-body pb-0">
            <h4 class="mb-0">{{tables.dashboards.items.filter(i => i.status_id == 2).length}}</h4>
            <p>Done Report(s)</p>
          </div>
          <card-bar-chart-example class="chart-wrapper px-3" style="height:70px;" height="70" />
        </b-card>
      </div>
      <!--/.col-->
      <div class="col-sm-6 col-lg-3">
        <b-card class="bg-warning" :no-block="true">
          <div class="card-body pb-0">
            <h4 class="mb-0">{{tables.dashboards.items.filter(i => i.status_id == 0).length}}</h4>
            <p>Pending Report(s)</p>
          </div>
          <card-line3-chart-example class="chart-wrapper" style="height:70px;" height="70" />
        </b-card>
      </div>
      <!--/.col-->
      <div class="col-sm-6 col-lg-3">
        <b-card class="bg-danger" :no-block="true">
          <div class="card-body pb-0">
            <h4 class="mb-0">{{accounts}}</h4>
            <p>Account(s)</p>
          </div>
          <card-bar-chart-example class="chart-wrapper px-3" style="height:70px;" height="70" />
        </b-card>
      </div>

      <!--/.col-->
    </div>
    <!--/.row-->
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
          <b-button class="mt-4 btn-success" style="float-center; width:100%; height: 30px">
            <i class="fa fa-print"></i> Print Report
          </b-button>
        </b-col>

        <b-col sm="3">
          <label>From Date</label>
          <date-picker
            id="from_datetime"
            format="MMMM/DD/YYYY"
            type="date"
            lang="en"
            input-class="form-control mx-input"
            v-model="from_datetime"
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
            v-model="to_datetime"
            ref="to_datetime"
            :clearable="false"
          ></date-picker>
        </b-col>
        <b-col sm="3">
          <b-form-input
            class="mt-4"
            v-model="filters.dashboards.criteria"
            type="text"
            placeholder="Search"
          ></b-form-input>
        </b-col>
      </b-row>
      <b-table
        responsive
        striped
        hover
        small
        bordered
        show-empty
        :fields="tables.dashboards.fields"
        :items="filterReports"
        :filter="filters.dashboards.criteria"
      ></b-table>
    </b-card>
    <!--/.row-->
  </div>
</template>

<script>
import CardLine1ChartExample from "./dashboard/CardLine1ChartExample";
import CardLine2ChartExample from "./dashboard/CardLine2ChartExample";
import CardLine3ChartExample from "./dashboard/CardLine3ChartExample";
import CardBarChartExample from "./dashboard/CardBarChartExample";
import MainChartExample from "./dashboard/MainChartExample";
import SocialBoxChartExample from "./dashboard/SocialBoxChartExample";
import { Callout } from "../components/";

export default {
  name: "dashboard",
  components: {
    Callout,
    CardLine1ChartExample,
    CardLine2ChartExample,
    CardLine3ChartExample,
    CardBarChartExample,
    MainChartExample,
    SocialBoxChartExample
  },
  data: function() {
    return {
      forms: {
        dashboard: {
          fields: {
            from_datetime: new Date()
          }
        }
      },
      tables: {
        dashboards: {
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
              key: "situation_name",
              label: "Situation",

              tdClass: "text-center"
            }
          ],
          items: []
        }
      },

      filters: {
        dashboards: {
          criteria: null
        }
      },
      options: {
        departments: {
          items: []
        }
      },
      accounts: 0,
      from_datetime: null,
      to_datetime: null
    };
  },
  methods: {
    variant(value) {
      let $variant;
      if (value <= 25) {
        $variant = "info";
      } else if (value > 25 && value <= 50) {
        $variant = "success";
      } else if (value > 50 && value <= 75) {
        $variant = "warning";
      } else if (value > 75 && value <= 100) {
        $variant = "danger";
      }
      return $variant;
    }
  },
  computed: {
    filterReports() {
      if (this.from_datetime != null && this.to_datetime != null) {
        return this.tables.dashboards.items.filter(
          d =>
            this.moment(d.send_datetime, "YYYY-MM-DD") >=
              this.moment(this.from_datetime, "YYYY-MM-DD") &&
            this.moment(d.send_datetime, "YYYY-MM-DD") <=
              this.moment(this.to_datetime, "YYYY-MM-DD")
        );
      } else {
        return this.tables.dashboards.items;
      }
    }
  },
  created() {
    this.$http
      .get("api/dashboards", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        this.tables.dashboards.items = response.data.dashboards;
        this.options.departments.items = response.data.departments;
        this.accounts = response.data.accounts;
      })
      .catch(error => {
        console.log(error);
      });
    // this.fillTableList("dashboards");
  }
};
</script>
