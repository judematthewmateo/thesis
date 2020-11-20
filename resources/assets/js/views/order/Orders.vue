
<template>
    <div>
        <notifications group="notification" />
        <div class="animated fadeIn">
            <b-row>
        <!-- main row -->
        <b-col sm="12">
          <b-card>
            <!-- main card -->
            <h5 slot="header">
              <!-- table header -->
              <span class="text-primary">
                <i class="fa fa-bars"></i>
                Orders
              </span>
            </h5>
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
                  :fields="tables.sohr.fields"
                  :items="filterReports($store.state.user.sumr_hash)"
                  :filter="filters.sohr.criteria"
                >
                   <template v-slot:cell(show_details)="row">
                     
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
                    
                          <div class="row">
                            <b-col lg="4">
                              <b-form-group>
                                <label>Costumer Name :</label>
                            <b-form-input disabled
                              v-model="this.fullname">
                            </b-form-input>
                             </b-form-group>
                              <b-form-group>
                                <label>Costumer Address :</label>
                            <b-form-input disabled>
                              
                            </b-form-input>
                             </b-form-group>
                              </b-col>

                            <b-col lg="4">
                              <br>
                              <br>
                                <b-form-group label="Select type of Delivery" style="text-align:center; font-size:12px;">
                                <b-form-radio  name="some-radios" value="A">Deliver</b-form-radio>
                                <b-form-radio  name="some-radios" value="B">Pick Up</b-form-radio>
                                </b-form-group>
                           
                            </b-col>
                            <b-col lg="4">

                              <br>
                              <br>
                              <br>
                              <br>
                              <br>
                              <b-form-group style="text-align:center;">
                              <b-button variant="success">Approve</b-button>
                              <b-button variant="danger">Decline</b-button>
                              </b-form-group>
                            </b-col>
                          </div>
                            
                         <b-table
                              responsive
                              striped
                              hover
                              small
                              bordered
                              show-empty
                              :fields="tables.soln.fields"
                              :items="solnfilter(row.item.sohr_hash)"
                              :filter="filters.soln.criteria"
                              
                            >
                         </b-table  >
                  
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
</template>
<script>
  export default {
    data() {
      return {
        // entryMode: "Add",
        // showModalProducts: false, 
        // showModalDelete: false,
        forms: { 
            sohr: {
                    isSaving: false,
                    isDeleting: false,
                    order_no: null
          },
        },
        tables: {
          sohr: {
            fields: [ 
              {
                key: "sohr_hash",
                label: "No.",
                tdClass: "align-middle",
                thStyle: { width: "40px" },
                sortable: true
              },
              {
                key: "order_no",
                label: "Order Number",
                tdClass: "align-middle",
                thStyle: { width: "100px" },
                sortable: true
              },
              {
                key: "order_date",
                label: "Order Date",
                tdClass: "align-middle",
                thStyle: { width: "100px" },
                sortable: true
              },
              {
                key: "payment_method",
                label: "Payment Method",
                tdClass: "align-middle",
                thStyle: { width: "100px" },
                sortable: true
              },
              {
                key: "order_subtotal",
                label: "Order Subtotal",
                tdClass: "align-middle text-right",
                thStyle: { width: "100px" },
                sortable: true,
                 formatter: (value) => {
                        return this.formatNumber(value)
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
            soln: {
              fields: [
                {
                key: "soln_hash",
                label: "No.",
                tdClass: "align-middle",
                thStyle: { width: "40px" },
                sortable: false
                },
                {
                key: "product_name",
                label: "Product Name",
                tdClass: "align-middle",
                thStyle: { width: "40px" },
                sortable: false
                },
                {
                key: "qty",
                label: "Quantity",
                tdClass: "align-middle",
                thStyle: { width: "40px" },
                sortable: false
                },
                 {
                key: "unit_price",
                label: "Price",
                tdClass: "align-middle text-right",
                thStyle: { width: "100px" },
                sortable: true,
                 formatter: (value) => {
                        return this.formatNumber(value)
                    }
                },
              ],
            items: []
          }
        },
        filters: {
          sohr: {
            criteria: null
          },
          soln: {
            criteria: null
          }
        },
             
        // options: {
        //   products: {
        //     items: []
        //   }
        // },
        paginations: {
          sohr: {
            totalRows: 0,
            currentPage: 1,
            perPage: 10
          }
        },
        sohr_hash: null,
        order_no: null,
        row: []
      };
    },
    methods: {
  
      filterReports(sumr_hash) {
      return this.tables.sohr.items.filter(r => r.sumr_hash == sumr_hash);
    },
      solnfilter(sohr_hash) {
      return this.tables.soln.items.filter(r => r.sohr_hash == sohr_hash);
    }
    },

    created() {
            //name of table
            this.$http

      .get("api/sohr", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        this.tables.sohr.items = response.data.sohr;
        this.tables.soln.items = response.data.soln;
        this.paginations.sohr.totalRows =
          response.data.sohr.length;
        // this.options.sohr.items = response.data.sohr;
      })
      .catch(error => {
        console.log(error);
      });
  }
};
</script>