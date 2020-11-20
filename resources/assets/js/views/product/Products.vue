<style lang=scss scoped>
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  margin: 0;
}
.img {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  width: 70%;
  height: 70%;
  padding: 0%;
}

.img:hover {
  box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}

</style>
<template>
    <div><!-- main container -->
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
                Product List
                
              </span>
            </h5>
            <b-row class="mb-2">
              <!-- row button and search input -->
              <b-col sm="4">
                <b-button
                  variant="primary"
                  @click="showModalProducts=true, entryMode='Add', clearFields('products'), image='' "
                >
                  <i class="fa fa-plus-circle"></i> Add New Product
                </b-button>
              </b-col>

              <b-col sm="4">
                <span></span>
              </b-col>

              <b-col sm="4">
                <b-form-input
                 v-model="filters.products.criteria"
                  type="text"
                  placeholder="Search"
                ></b-form-input>
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
                  :fields="tables.products.fields"
                  :items="filterProduct($store.state.user.sumr_hash)"
                  :filter="filters.products.criteria"
                >
                <template v-slot:cell(action)="data">
                  
                    <b-btn :size="'sm'" variant="success" @click="setUpdate(data)">
                      <i class="fa fa-edit"></i>
                    </b-btn>

                    <b-btn
                      :size="'sm'"
                      :disabled="forms.products.isDeleting"
                      variant="danger"
                      @click="setDelete(data)"
                    >
                      <icon v-if="forms.products.isDeleting" name="sync" spin></icon>
                      <i v-else class="fa fa-trash"></i>
                    </b-btn>
                  </template>
                </b-table>
                <!-- table -->
              </b-col>
            </b-row>
            <b-row>
              <!-- Pagination -->
              <b-col sm="12" class="m-1">
                <b-pagination
                  size="sm"
                  align="right"
                  :total-rows="paginations.products.totalRows"
                  :per-page="paginations.products.perPage"
                  v-model="paginations.products.currentPage"
                  class="my-0"
                />
                  </b-col>
                </b-row>
              </b-card>
            </b-col>
          </b-row>

        <div>
          <b-modal
          size="lg"
          v-model="showModalProducts"
          :noCloseOnEsc="true"
          :noCloseOnBackdrop="true"
          :scrollable="true"
          @shown="focusElement('product_name')">
          
        
            <!-- modal title -->

            
            <h5 style="text-align: center">
              <!-- table header -->
              <label class="text-primary" style="text-align: center">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                {{entryMode}} Product
              </label>
            </h5>
      
        <b-row lg="12">
          <b-col lg=6> 
                <b-form @keydown="resetFieldStates('products')" autocomplete="off">
                    <b-form-group>
                        <label for="product_name"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Product Name</label>
                        <b-form-input
                            id="product_name"
                            v-model="forms.products.fields.product_name"
                            type="text"
                            placeholder="Product Name"
                            ref="product_name">
                        </b-form-input>
                    </b-form-group>
                          <b-form-group>
                        <label for="product_details"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Product Details</label>
                        <b-form-input
                            id="product_details"
                            v-model="forms.products.fields.product_details"
                            type="text"
                            placeholder="Product Details"
                            ref="product_details">
                        </b-form-input>
                    </b-form-group>
                      <b-form-group>
                        <label for="onhand_qty"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> On hand Quantity</label>
                      <b-form-input
                            ref="onhand_qty"
                            id="onhand_qty"
                            v-model="forms.products.fields.onhand_qty"
                            type="number"
                            placeholder="On Hand Quantity">
                        </b-form-input>
                    </b-form-group>
                           <b-form-group>
                        <label for="available_qty"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Available Quantity</label>
                      
                     <b-form-input
                            ref="available_qty"
                            id="available_qty"
                            v-model="forms.products.fields.available_qty"
                            type="number"
                            placeholder="Available Quantity">
                        </b-form-input>
                      </b-form-group>
                      <b-form-group>
                                <label>Price</label>
                                <vue-autonumeric
                                    ref="cost_amt"
                                    id="cost_amt"
                                    v-model="forms.products.fields.cost_amt"
                                    class='form-control text-right'
                                :options="{
                                        minimumValue: '0',
                                        decimalCharacter: '.', 
                                        emptyInputBehavior:'0',}"
                            ></vue-autonumeric>
                  </b-form-group>
                    
                   </b-form>
                  </b-col>
        <b-col lg="6">
        <div class="row">
        <label>Select Images</label>
              <b-form-file name="picture" id="picture" @change="onFileChange">
              </b-form-file>
              <img class="img" :src="imagePreview" width="70%" height="70%" v-show="showPreview">
        </div>
          </b-col>
          </b-row>
          <div slot="modal-footer"><!-- modal footer buttons -->
                <b-button :disabled="forms.products.isSaving" variant="primary" @click="onProductEntry">
                    <icon v-if="forms.products.isSaving" name="sync" spin></icon>
                    <i class="fa fa-check"></i>
                    Save
                </b-button>
                <b-button variant="secondary" @click="showModalProducts=false">Close</b-button>
            </div>
          </b-modal>
           <b-modal 
                v-model="showModalDelete"
                :noCloseOnEsc="true"
                :noCloseOnBackdrop="true"
            >
                <div slot="modal-title">
                    Delete Product
                </div>
                <b-col lg=12>
                    Are you sure you want to delete this Product?
                </b-col>
                <div slot="modal-footer">
                    <b-button :disabled="forms.products.isSaving" variant="primary" @click="onProductsDelete">
                        <icon v-if="forms.products.isSaving" name="sync" spin></icon>
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
    data() {
      return {
        // isDragging: false, dragCount: 0, files: [],images: [] ,progress:0,
        entryMode: "Add",
        showModalProducts: false, 
        showModalDelete: false,
        picture: [],
        imagePreview: null,
        showPreview: false,
        forms: { 
            products: {
            isSaving: false,
            isDeleting: false,
            fields: {
               product_name: null,
               product_details: null,
               onhand_qty: null,
               available_qty: null,
               cost_amt: null
            },
          
          },

      
        },
        tables: {
          products: {
            fields: [
              {
                key: "product_name",
                label: "Product Name",
                tdClass: "align-middle",
                thStyle: { width: "250px" },
                sortable: true
              },
              {
                key: "product_details",
                label: "Product Details",
                tdClass: "align-middle",
                thStyle: { width: "120px" },
                sortable: true
              },
              {
                key: "onhand_qty",
                label: "On hand Qty.",
                tdClass: "align-middle",
                thStyle: { width: "100px" },
                sortable: true
              },
              {
                key: "available_qty",
                label: "Available Qty.",
                tdClass: "align-middle",
                thStyle: { width: "100px" },
                sortable: true
              },
                {
                key: "sales",
                label: "Sales",
                tdClass: "align-middle",
                thStyle: { width: "80px" },
                sortable: true
              },
                {
                key: "cost_amt",
                label: "Price",           
                thClass: "text-right",
                tdClass: "align-middle text-right",
                thStyle: { width: "120px" },
                sortable: true,
                 formatter: (value) => {
                        return this.formatNumber(value)
                    }
              },

              {
                key: "action",
                label: "",
                thStyle: { width: "120px" },
                tdClass: "text-center"
              }
            ],
            items: []
          }
        },
        filters: {
          products: {
            criteria: null
          }
        },
        paginations: {
          products: {
            totalRows: 0,
            currentPage: 1,
            perPage: 10
          }
        },
        inmr_hash: null,
        row: []
      };
    },
     methods: { 
       onFileChange(event){
    /*
    Set the local file variable to what the user has selected.
    */
    this.picture = event.target.files[0];

    /*
    Initialize a File Reader object
    */
    let reader  = new FileReader();

    /*
    Add an event listener to the reader that when the file
    has been loaded, we flag the show preview as true and set the
    image to be what was read from the reader.
    */
    reader.addEventListener("load", function () {
        this.showPreview = true;
        this.imagePreview = reader.result;
    }.bind(this), false);

    /*
    Check to see if the file is not empty.
    */
    if( this.picture ){
        /*
            Ensure the file is an image file.
        */
        if ( /\.(jpe?g|png)$/i.test( this.picture.name ) ) {

            console.log("here");
            /*
            Fire the readAsDataURL method which will read the file in and
            upon completion fire a 'load' event which we will listen to and
            display the image in the preview.
            */
            reader.readAsDataURL( this.picture );
        }
    }
},

      filterProduct(sumr_hash) {
      return this.tables.products.items.filter(r => r.sumr_hash == sumr_hash);
      },
      onProductEntry() {
        if (this.entryMode == "Add") {
          //name of form
          //if from a modal?
          //name of table to be inserted
          this.createEntity("products", true, "products");
        } else {
          //name of form
          //name of primary key
          //if from a modal?
          //row to be edited
          this.updateEntity("products", "inmr_hash", true, this.row);
        }
      },
    
        onInputChange(e) {  const files = e.target.files;
                            Array.from(files).forEach(file => this.addImage(file));
                        },
        addImage(file) {console.log('addimage file=',file)
            if (!file.type.match('image.*')) {  this.$toastr.e(`${file.name} is not an image`);
                                                return;
                                            }
                        this.files.push(file);
                        const img = new Image(),
                        reader = new FileReader();
                        reader.onload = (e) => this.images.push(e.target.result);
                        reader.readAsDataURL(file);
                        console.log('addimage this.images=',this.images)
                    },
      onProductsDelete() {
        this.deleteEntity(
          "products",
          this.inmr_hash,
          true,
          "products",
          "inmr_hash"
        );
      },
      async setDelete(data) {
        this.inmr_hash = data.item.inmr_hash;
        this.showModalDelete = true;
      },
     
      setUpdate(data) {
        this.row = data.item;
        this.resetFieldStates("products");
        this.fillEntityForm("products", data.item.inmr_hash);
        this.showModalProducts = true;
        this.entryMode = "Edit";
      }
     },
 created () {
      //name of table
      this.fillTableList('products')
    }
  }
</script>




              