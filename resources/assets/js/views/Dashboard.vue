<style scoped>
.w-card:hover {
  cursor: pointer;
}
.t-card {
  width: 80%;
  margin-left: 10%;
}
.try {
  margin-top: -35%;;
}
</style>
<template>
  <div>
  <notifications group="notification" />
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-sm-6 col-lg-3">
        <b-card class="bg-primary w-card" @click="newOrderEntry = true,IntransitEntry = false, DeliverEntry = false, CompletedEntry = false">
          <div class="card-body pb-0">
            <b-row>
            <b-col lg="6">
            <h3 class="mb-0">{{tables.sohr.items.filter(i => i.status_merc == "NEW ORDER").length}}</h3>
            <p style="font-size: 12px">New Order(s)</p>
            </b-col>
             <b-col lg="6">
               <a class="fa fa-shopping-cart float-right" style="font-size:60px;padding:0%;"></a>
             </b-col>
          </b-row>
          </div>
        </b-card>
      </div>
      <!--/.col-->
      <div class="col-sm-6 col-lg-3">
        <b-card class="bg-success w-card" @click="IntransitEntry = true ,newOrderEntry = false, DeliverEntry = false, CompletedEntry = false" style="cursor:pointer !impotant;">
          <div class="card-body pb-0">
            <b-row>
            <b-col lg="6">
            
            
            <h3 class="mb-0">{{tables.sohr.items.filter(i => i.status_merc == "TO DELIVER" || "TO PICK UP" || "FOR DISPATCH" ).length}}</h3>
            <p class="mb-0" style="font-size: 12px">In - transit(s) &nbsp; <i class="fa fa-angle-double-down" aria-hidden="true"></i></p>
            <b-row> 
            <p class="mb-0" style="font-size: 12px"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To Deliver(s) : &nbsp;</p>
            <h6 class="mb-0">{{tables.sohr.items.filter(i => i.status_merc == "TO DELIVER" ).length}}</h6>
            </b-row>
            <b-row>
            <p class="mb-0" style="font-size: 12px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To Pick Up(s) : &nbsp;</p>
            <h6 class="mb-0">{{tables.sohr.items.filter(i => i.status_merc == "TO PICK UP").length}}</h6>
            </b-row>
            <b-row>
            <p class="mb-0" style="font-size: 12px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;For Dispatch(s) : &nbsp;</p>
            <h6 class="mb-0">{{tables.sohr.items.filter(i => i.status_merc == "FOR DISPATCH").length}}</h6>
            </b-row>
            </b-col>
             <b-col lg="6">
               <a class="fa fa-truck float-right" style="font-size:60px;padding:0%;"></a>
             </b-col>
          </b-row>
          </div>
         </b-card>
      </div>
      <!--/.col-->
      <div class="col-sm-6 col-lg-3">
        <b-card class="bg-warning w-card" :no-block="true" @click="DeliverEntry = true, IntransitEntry = false ,newOrderEntry = false, CompletedEntry = false">
          <div class="card-body pb-0">
            <b-row>
            <b-col lg="6">
            <h3 class="mb-0">{{tables.sohr.items.filter(i => i.status_merc == "DELIVERY"  || i.status_merc == "DELIVERED").length}}</h3>
            <p style="font-size: 12px">Delivery(s)</p>
            </b-col>
             <b-col lg="6">
               <a class="fa fa-arrow-circle-o-right float-right" style="font-size:60px;padding:0%;"></a>
             </b-col>
          </b-row>
          </div>
        </b-card>
      </div>
      <!--/.col-->
      <div class="col-sm-6 col-lg-3">
        <b-card class="bg-danger w-card" :no-block="true" @click="CompletedEntry = true,DeliverEntry = false, IntransitEntry = false ,newOrderEntry = false">
          <div class="card-body pb-0">
            <b-row>
            <b-col lg="6">
            <h3 class="mb-0">{{tables.sohr.items.filter(i => i.status_merc == "COMPLETED" && i.status_user == "COMPLETED").length}}</h3>
            <p style="font-size: 12px">Completed(s)</p>
            </b-col>
             <b-col lg="6">
               <a class="fa fa-check-square float-right" style="font-size:60px;padding:0%;"></a>
               
             </b-col>
          </b-row>
          </div>
        </b-card>
      </div>
   
    <b-card class="t-card animated" v-show="newOrderEntry" >
      <h5 slot="header">

        <span class="text-primary">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
          New Order
        </span>
      </h5>
      <b-table
        responsive
        striped
        hover
        small
        bordered
        show-empty
        :fields="tables.sohr.fields"
        :items="NeworderFilter(tables.sohr.items.sohr_hash)"
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
                    v-model="row.item.fullname">
                  </b-form-input>
                    </b-form-group>
                    <b-form-group>
                      <label>Costumer Address :</label>
                  <b-form-input disabled
                   v-model="row.item.address">
                    
                  </b-form-input>
                    </b-form-group>
                    </b-col>
                  <b-col lg="4">
                          <h1 v-show="row.item.is_cancel == 1">&nbsp; &nbsp; &nbsp;CANCELLED</h1>
                          <b-form-group class="m-3" v-show="radiobutton" v-model="radiobtn">
                          <label>Select type of delivery</label>
                         <b-form-radio-group
                          id="btn-radios-2"
                          v-model="forms.dashboard.fields.selected"
                          :options="options"
                          buttons
                          button-variant="outline-primary"
                          size="lg"
                          name="radio-btn-outline"
                        ></b-form-radio-group>
                          </b-form-group>
                  </b-col>
                  <b-col lg="4">
                    <br>
                    <b-form-group v-show="row.item.dh_remarks != null" >
                  <label>Cancellation Remarks :</label>
                 <b-form-textarea 
                  v-model="row.item.dh_remarks"
                  
                  disabled>
                 </b-form-textarea>
                 </b-form-group>
                   <br>
                    <b-form-group style="text-align:center;" v-show="btnneworder">
                    <b-button  @click="AcceptNewOrders(row)" variant="success"><i class="fa fa-check-square-o" aria-hidden="true"></i> Accept</b-button>
                    <b-button  @click="DeclineNewOrders(row)" variant="danger"><i class="fa fa-times" aria-hidden="true"></i> Decline</b-button>
                    </b-form-group>
                  </b-col>
                </div>
                   <b-row>
                <b-col sm="12">
                <b-table
                    responsive
                    striped
                    hover
                    small
                    bordered
                    show-empty
                    :fields="tables.soln.fields"
                    :items="solnfilter(row.item.sohr_hash)"
                  >
                </b-table  >
                </b-col>
                </b-row>
                <b-modal v-model="showModalAcceptNewOrderDeliver" :noCloseOnEsc="true" :noCloseOnBackdrop="true">
                <div slot="modal-title">Accept New Order?</div>
                <b-col lg="12">Are you sure you want to Accept this Order?</b-col>
                <div slot="modal-footer">
                  <b-button
                    class="button"
                    :disabled="forms.dashboard.isSaving"
                    variant="primary"
                    @click="onAcceptingNewOrder"
                  >
                    <icon v-if="forms.dashboard.isSaving" name="sync" spin></icon>
                    <i class="fa fa-check"></i>
                    I will Accept
                  </b-button>
                  <b-button class="button" variant="secondary" @click="showModalAcceptNewOrderDeliver=false">Close</b-button>
                </div>
                 </b-modal>
                  <b-modal v-model="showModalAcceptNewOrderPickUp" :noCloseOnEsc="true" :noCloseOnBackdrop="true">
                <div slot="modal-title">Accept New Order?</div>
                  <b-row>
                  <b-col lg="12">
                  <p>Are you sure you want to Accept this Order?</p>
                  <label>Pick Up Date :</label>
                  <date-picker
                    id="to_pick_datetime"
                    format="MMMM/DD/YYYY"
                    type="date"
                    lang="en"
                    input-class="form-control mx-input"
                    v-model="forms.dashboard.fields.to_pick_datetime"
                    ref="to_pick_datetime"
                    :clearable="false"
                  ></date-picker>
                    <label>Merchant Address :</label>
                    <b-form-input 
                    disabled
                    v-model="row.item.sumr_address"
                    >
                    </b-form-input>
                </b-col>
                </b-row>
                <div slot="modal-footer">
                  <b-button
                    class="button"
                    :disabled="forms.dashboard.isSaving"
                    variant="primary"
                    @click="onAcceptingNewOrder"
                  >
                    <icon v-if="forms.dashboard.isSaving" name="sync" spin></icon>
                    <i class="fa fa-check"></i>
                    I will Accept
                  </b-button>
                  <b-button class="button" variant="secondary" @click="showModalAcceptNewOrderPickUp=false">Close</b-button>
                </div>
                 </b-modal>
                 <b-modal v-model="showModalDeclineNewOrder" :noCloseOnEsc="true" :noCloseOnBackdrop="true"> 
                 <div slot="modal-title">Decline Order?</div>
                 <b-col lg="12"><h6>Reason for declining</h6></b-col>
                  <b-form-textarea
                  id="textarea"
                  placeholder="Enter something..."
                  rows="3"
                  max-rows="6"
                  v-model="forms.dashboard.fields.decline_neworder_remarks"
                  ></b-form-textarea>
                  <div slot="modal-footer">
                  <b-button
                    class="button"
                    :disabled="forms.dashboard.isSaving"
                    variant="primary"
                    @click="onDeclineNewOrder"
                  >
                    <icon v-if="forms.dashboard.isSaving" name="sync" spin></icon>
                    <i class="fa fa-check"></i>
                    Submit
                  </b-button>
                  <b-button class="button" variant="secondary" @click="showModalDeclineNewOrder=false">Close</b-button>
                </div>
                 </b-modal>
          </template>
      </b-table>
    </b-card>
    <b-card class="t-card animated" v-show="IntransitEntry">
      <h5 slot="header">

        <span class="text-primary">
          <i class="fa fa-truck"></i>
          In - Transit
        </span>
      </h5>
       <b-row class="mb-2">
        <!-- row button and search input -->
        
        <b-col sm="3">
       <div>
            <select class="form-control" style="padding:0px; font-size:14px;" id="sort_trans" ref="sort_trans" v-model="sort_trans" >
                <option value="">All</option>
                <option value="0" >To Deliver</option>
                <option value="1" >To Pick UP</option>
                <option value="2" >For Dispatch</option>
            </select>
        </div>
        </b-col>
        <b-col sm="3">
          <date-picker
            id="date"
            format="MMMM/DD/YYYY"
            type="date"
            lang="en"
            input-class="form-control mx-input"
            v-model="forms.dashboard.fields.date"
            ref="date"
            :clearable="false"
          ></date-picker>
        </b-col>
        <b-button @click="forms.dashboard.fields.date = null"></b-button>
      </b-row>
      <b-table
        responsive
        striped
        hover
        small
        bordered
        show-empty
        :fields="tables.sohr.fields"
        :items="InTransitFilter"
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
                    v-model="row.item.fullname">
                  </b-form-input>
                    </b-form-group>
                    <b-form-group>
                      <label>Costumer Address :</label>
                  <b-form-input disabled
                   v-model="row.item.address">
                  </b-form-input>
                    </b-form-group>
                    </b-col>
                  <b-col lg="4">
                    <b-form-group>
                    <label>Merchant Name :</label>
                    <b-form-input 
                    disabled
                    v-model="row.item.seller_name"
                    >
                    </b-form-input>
                    </b-form-group>
                    <b-form-group>
                   <label>Merchant Address :</label>
                  <b-form-input disabled
                   v-model="row.item.sumr_address">
                  </b-form-input>
                    </b-form-group>
                  </b-col>
                  <b-col lg="4">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <b-form-group style="text-align:center;" v-model="transitbtn" v-show="transitbutton">
                    <b-button  @click="AcceptIntransit(row)" variant="success"><i class="fa fa-check-square-o" aria-hidden="true"></i> Accept</b-button>
                    <b-button  @click="DeclineIntransit(row)" variant="danger"><i class="fa fa-times" aria-hidden="true"></i> Decline</b-button>
                    </b-form-group>
                  </b-col>
                </div>
                   <b-row>
                <b-col sm="12">
                <b-table
                    responsive
                    striped
                    hover
                    small
                    bordered
                    show-empty
                    :fields="tables.soln.fields"
                    :items="solnfilter(row.item.sohr_hash)"
                  >
                </b-table  >
                </b-col>
                </b-row>
                <b-modal v-model="showModalAcceptIntransit" :noCloseOnEsc="true" :noCloseOnBackdrop="true">
                <div slot="modal-title">Accept New Order?</div>
                <b-col lg="12">Are you sure you want to Accept this Order?</b-col>
                <div slot="modal-footer">
                  <b-button
                    class="button"
                    :disabled="forms.dashboard.isSaving"
                    variant="primary"
                    @click="onAcceptingIntransit"
                  >
                    <icon v-if="forms.dashboard.isSaving" name="sync" spin></icon>
                    <i class="fa fa-check"></i>
                    I will Accept
                  </b-button>
                  <b-button class="button" variant="secondary" @click="showModalAcceptIntransit=false">Close</b-button>
                </div>
                 </b-modal>
                 <b-modal v-model="showModalDeclineNewOrder" :noCloseOnEsc="true" :noCloseOnBackdrop="true"> 
                 <div slot="modal-title">Decline Order?</div>
                 <b-col lg="12"><h6>Reason for declining</h6></b-col>
                  <b-form-textarea
                  id="textarea"
                  placeholder="Enter something..."
                  rows="3"
                  max-rows="6"
                  ></b-form-textarea>
                  <div slot="modal-footer">
                  <b-button
                    class="button"
                    :disabled="forms.dashboard.isSaving"
                    variant="primary"
                  >
                    <icon v-if="forms.dashboard.isSaving" name="sync" spin></icon>
                    <i class="fa fa-check"></i>
                    Submit
                  </b-button>
                  <b-button class="button" variant="secondary" @click="showModalDeclineNewOrder=false">Close</b-button>
                </div>
                 </b-modal>
          </template>
      </b-table>
    </b-card>
      <b-card class="t-card animated" v-show="DeliverEntry">
      <h5 slot="header">

        <span class="text-primary">
          <i class="fa fa-arrow-circle-o-right"></i>
          Delivery
          <!-- <small class="font-italic"></small> -->
        </span>
      </h5>
      <b-row class="mb-2">
        <!-- row button and search input -->
        <b-col sm="3">
          <div>
            <select class="form-control" style="padding:0px; font-size:14px;" id="sort_deliver" ref="sort_deliver" v-model="sort_deliver">
                <option value="">All</option>
                <option value="1" >To Deliver</option>
                <option value="0" >Delivered</option>
            </select>
        </div>
        </b-col>
        <b-col sm="3">
        </b-col>
      </b-row>
        <b-table
        responsive
        striped
        hover
        small
        bordered
        show-empty
        :fields="tables.sohr.fields"
        :items="DeliveryFilter"
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
                    v-model="row.item.fullname">
                  </b-form-input>
                    </b-form-group>
                    <b-form-group>
                      <label>Costumer Address :</label>
                  <b-form-input disabled
                   v-model="row.item.address">
                  </b-form-input>
                    </b-form-group>
                    </b-col>
                  <b-col lg="4">
                     <span>
                     </span>
                  </b-col>
                  <b-col lg="4">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <b-form-group style="text-align:center;" v-model="transitbtn" v-show="transitbutton">
                    <b-button @click="Delivered(row)" variant="success"><i class="fa fa-check-square-o" aria-hidden="true"></i> Delivered</b-button>
                    <b-button  variant="danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</b-button>
                    </b-form-group>
                  </b-col>
                </div>
                   <b-row>
                <b-col sm="12">
                <b-table
                    responsive
                    striped
                    hover
                    small
                    bordered
                    show-empty
                    :fields="tables.soln.fields"
                    :items="solnfilter(row.item.sohr_hash)"
                  >
                </b-table  >
                </b-col>
                </b-row>
                 <b-modal v-model="showModalDelivered" :noCloseOnEsc="true" :noCloseOnBackdrop="true">
                <div slot="modal-title">Delivered?</div>

                <b-col lg="12">Are you sure the Parcel has been delivered?</b-col>
                <div slot="modal-footer">
                  <b-button
                    class="button"
                    :disabled="forms.dashboard.isSaving"
                    variant="primary"
                    @click="onDelivered"
                  >
                    <icon v-if="forms.dashboard.isSaving" name="sync" spin></icon>
                    <i class="fa fa-check"></i>
                    Yes
                  </b-button>
                  <b-button class="button" variant="secondary" @click="showModalDelivered=false">No</b-button>
                </div>
                 </b-modal>
          </template>
          </b-table>
    </b-card>
     <b-card class="t-card animated" v-show="CompletedEntry">
      <h5 slot="header">

        <span class="text-primary">
          <i class="fa fa-check-square" aria-hidden="true"></i>
          Completed
          <!-- <small class="font-italic"></small> -->
        </span>
      </h5>
      <b-row class="mb-2">
        <!-- row button and search input -->
        <b-col sm="3">
        </b-col>
      </b-row>
        <b-table
        responsive
        striped
        hover
        small
        bordered
        show-empty
        :fields="tables.sohr.fields"
        :items="CompletedFilter(tables.sohr.items.sohr_hash)"
      ></b-table>
      
    </b-card>
    </div>
    </div>
      <!--/.col-->
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
      newOrderEntry: true,
      IntransitEntry: false,
      radiobutton: false,
      transitbutton: false,
      btnneworder: false,
      DeliverEntry: false,
      CompletedEntry: false,
      sort_trans: "",
      sort_deliver: "",
      showModalAcceptNewOrderPickUp: false,
      showModalAcceptNewOrderDeliver: false,
      showModalDeclineNewOrder: false,
      showModalAcceptIntransit: false,
      showModalDelivered: false,
      remarkshow: false,
      
      
      
      options: [
          { text: 'TO DELIVER', value: 'TO DELIVER' },
          { text: 'TO PICK UP', value: 'TO PICK UP' },
        ],
      forms: {
        dashboard: {
          isSaving: false,
          isDeleting: false,
          fields: {
            selected: 'TO DELIVER',
            seller_address: null,
            decline_neworder_remarks: null,
            to_pick_datetime: new Date(),
            date: null,
          }
        }
      },
      tables: {
        sohr: {
          fields: [
            {
              key: "order_no",
              label: "Order No.",
              thStyle: { width: "80px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "order_date",
              label: "Order Date",
              tdClass: "align-middle",
              thStyle: { width: "80px" },
              sortable: true,
              formatter: value => {
                return this.moment(value, "MMMM DD, YYYY");
              }
            },
            {
              label: "Quantity",
              thStyle: { width: "80px" },
              tdClass: "align-middle",
              sortable: true
            }, 
            {
              key: "status_merc",
              label: "Status",
              thStyle: { width: "80px" },
              tdClass: "align-middle",
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
              thStyle: { width: "120px" },
              tdClass: "text-center"
            }
          ],
          items: []
        },
         soln: {
          fields: [
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
    }
  },
  methods: {
    removeProduct(index) {
      this.tables.soln.items.splice(index, 1);
    },
    onDeclineNewOrder() {
      console.log('sadasdasd')
      this.forms.dashboard.isSaving = true;
      this.$http
        .put(
          "api/declineneworder/delete/" + this.sohr_hash,
          this.forms.dashboard.fields,
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          }
        )
        .then(response => {
          this.forms.dashboard.isSaving = false;
          this.$notify({
            type: "success",
            group: "notification",
            title: "Success!",
            text: "The New Order has been Declined."
          });

          const index = this.tables.sohr.items.findIndex(
            item => item["sohr_hash"] === response.data.data["sohr_hash"]
          );

          // this.$delete(this.tables.sohr.items, index);
          // this.paginations.queuereports.totalRows--;

          this.showModalDeclineNewOrder = false;
        })
        .catch(error => {
          this.forms.dashboard.isSaving = false;
          if (!error.response) return;
          const errors = error.response.data.errors;
          console.log(errors);
        });
    },
    onAcceptingNewOrder() {
      this.forms.dashboard.isSaving = true;
      this.$http
        .put(
          "api/acceptneworder/delete/" + this.sohr_hash,
          this.forms.dashboard.fields,
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          }
        )
        .then(response => {
          this.forms.dashboard.isSaving = false;
          this.$notify({
            type: "success",
            group: "notification",
            title: "Success!",
            text: "The New Order has been Accepted."
          });

          const index = this.tables.sohr.items.findIndex(
            item => item["sohr_hash"] === response.data.data["sohr_hash"]
          );

          this.$delete(this.tables.sohr.items, index);
          // this.paginations.queuereports.totalRows--;

          this.showModalAcceptNewOrder = false;
          this.showModalAcceptNewOrderPickUp = false;
        })
        .catch(error => {
          this.forms.dashboard.isSaving = false;
          if (!error.response) return;
          const errors = error.response.data.errors;
          console.log(errors);
        });
    },
    
     onAcceptingIntransit() {
          this.forms.dashboard.isSaving = true
          this.$http.put("api/acceptintransit/" + this.sohr_hash,
          this.forms.dashboard.fields,
          {
            headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
            }
            )
            
          .then(response => {
          this.forms.dashboard.isSaving = false;
          this.$notify({
            type: "success",
            group: "notification",
            title: "Success!",
            text: "The New Order has been Accepted."
           
          });
          
          // for (var key in response.data.data) {
          //   row[key] = response.data.data[key];
          // }
          //     const index = this.tables.sohr.items.findIndex(
          //   item => item["sohr_hash"] === response.data.data["sohr_hash"]
          // );
                this.showModalAcceptIntransit = false
            })
    },
    onDelivered() {
      this.forms.dashboard.isSaving = true;
      this.$http
        .put(
          "api/delivered/delete/" + this.sohr_hash,
          this.forms.dashboard.fields,
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          }
        )
        .then(response => {
          this.forms.dashboard.isSaving = false;
          this.$notify({
            type: "success",
            group: "notification",
            title: "Success!",
            text: "The Parcel has been Delivered."
          });

          const index = this.tables.sohr.items.findIndex(
            item => item["sohr_hash"] === response.data.data["sohr_hash"]
          );

          this.$delete(this.tables.sohr.items, index);
          // this.paginations.queuereports.totalRows--;

          this.showModalAcceptNewOrder = false;
        })
        .catch(error => {
          this.forms.dashboard.isSaving = false;
          if (!error.response) return;
          const errors = error.response.data.errors;
          console.log(errors);
        });
    },
     async AcceptNewOrders(row) {
      this.sohr_hash = row.item.sohr_hash;
      if (this.forms.dashboard.fields.selected == "TO PICK UP") {
        this.showModalAcceptNewOrderPickUp = true;
      }else{
        this.showModalAcceptNewOrderDeliver = true
      }
    },
    AcceptIntransit(row) {
      this.sohr_hash = row.item.sohr_hash;
      this.showModalAcceptIntransit=true
    },
    async DeclineNewOrders(row) {
      
      this.sohr_hash = row.item.sohr_hash;
      this.showModalDeclineNewOrder = true;
    },
     async Delivered(row) {
      this.sohr_hash = row.item.sohr_hash;
      this.showModalDelivered = true;
    },
    NeworderFilter(sohr_hash){
         return this.tables.sohr.items.filter(r => r.status_merc == "NEW ORDER");
    },
    CompletedFilter(sohr_hash){
        return this.tables.sohr.items.filter(r => r.status_merc == "COMPLETED" && r.status_user == "COMPLETED");
    },
    solnfilter(sohr_hash) {
      return this.tables.soln.items.filter(r => r.sohr_hash == sohr_hash);
    },
  },
  computed: {
       InTransitFilter() {
       if (this.sort_trans =="0") {
           if (this.forms.dashboard.fields.date != null){
           return this.tables.sohr.items.filter(r => r.status_merc == "TO DELIVER" && 
           this.moment(r.order_date, "YYYY-MM-DD") ==
               this.moment(this.forms.dashboard.fields.date, "YYYY-MM-DD"));
          }else{
            return this.tables.sohr.items.filter(r => r.status_merc == "TO DELIVER")
          }
      }else if (this.sort_trans =="1" && this.forms.dashboard.fields.date != null){
                return this.tables.sohr.items.filter(r => r.status_merc == "TO PICK UP" , "READY TO PICK UP" ,
                this.moment(r => r.order_date, "YYYY-MM-DD") ==
                  this.moment(this.forms.dashboard.fields.date, "YYYY-MM-DD"));
      }else{
              return this.tables.sohr.items.filter(r => r.status_merc == "TO PICK UP" ||  r.status_merc == "TO DELIVER" || r.status_merc == "READY TO PICK UP" || r.status_merc == "FOR DISPATCH");

            }
      
    },
      DeliveryFilter() {
         this.tables.sohr.items.sohr_hash
         if (this.sort_deliver == "0") {
            return this.tables.sohr.items.filter(r => r.status_merc == "DELIVERED" && r.stat_delivery == '1');
         }else if (this. sort_deliver =="1"){
            return this.tables.sohr.items.filter(r => r.status_merc == "DELIVERY");
         }else{
           return this.tables.sohr.items.filter(r => r.status_merc == "DELIVERY" || r.status_merc == "DELIVERED");
         }
    },
      radiobtn() {
        if (this.$store.state.user.type == 1) {
            this.radiobutton = true
        }
    },
      transitbtn() {
        if (this.$store.state.user.type == 0) {
            this.transitbutton = true
            this.btnneworder = true
        }
    },
    
  },
  created() {
    this.$http
      .get("api/sohr", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        this.tables.sohr.items = response.data.sohr;
        this.tables.soln.items = response.data.soln;
        // // this.options.departments.items = response.data.departments;
        // this.accounts = response.data.accounts;
      })
      .catch(error => {
        console.log(error);
      });
  },
};
</script>
