<template>
  <div>
    <notifications group="notification" />
    <div class="animated fadeIn">
      <!-- main div -->

      <b-row>
        <!-- main row -->
        <b-col sm="12">
          <b-card>
            <!-- main card -->
            <h5 slot="header">
              <!-- table header -->
              <span class="text-primary">
                <i class="fa fa-bars"></i>
                Parts List
                <small class="font-italic">List of all registered Parts .</small>
              </span>
            </h5>
            <b-row class="mb-2">
              <!-- row button and search input -->
              <b-col sm="4">
                <b-button
                  variant="primary"
                  @click="showModalEntry = true, entryMode='Add', clearFields('part')"
                >
                  <i class="fa fa-plus-circle"></i> Add New Parts
                </b-button>
              </b-col>

              <b-col sm="4">
                <span></span>
              </b-col>

              <b-col sm="4">
                <b-form-input v-model="filters.parts.criteria" type="text" placeholder="Search"></b-form-input>
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
                  :filter="filters.parts.criteria"
                  :fields="tables.parts.fields"
                  :items.sync="tables.parts.items"
                  :current-page="paginations.parts.currentPage"
                  :per-page="paginations.parts.perPage"
                >
                  <!-- table -->

                  <template v-slot:cell(action)="data">
                    <!-- action slot  :to="{path: 'departments/' + data.item.id } -->
                    <b-btn :size="'sm'" variant="primary" @click="setUpdate(data)">
                      <i class="fa fa-edit"></i>
                    </b-btn>

                    <b-btn
                      :size="'sm'"
                      :disabled="forms.part.isDeleting"
                      variant="danger"
                      @click="setDelete(data)"
                    >
                      <icon v-if="forms.part.isDeleting" name="sync" spin></icon>
                      <i v-else class="fa fa-trash"></i>
                    </b-btn>
                  </template>
                </b-table>
                <!-- table -->
              </b-col>
            </b-row>
            <!-- row table -->

            <b-row>
              <!-- Pagination -->
              <b-col sm="12" class="my-1">
                <b-pagination
                  size="sm"
                  align="center"
                  :total-rows="paginations.parts.totalRows"
                  :per-page="paginations.parts.perPage"
                  v-model="paginations.parts.currentPage"
                  class="my-0"
                />
              </b-col>
            </b-row>
            <!-- Pagination -->
          </b-card>
          <!-- main card -->
        </b-col>
      </b-row>
      <!-- main row -->
    </div>

    <div>
      <!-- modal div -->
      <b-modal
        v-model="showModalEntry"
        :noCloseOnEsc="true"
        :noCloseOnBackdrop="true"
        @shown="focusElement('part_code')"
      >
        <div slot="modal-title">
          <!-- modal title -->
          Add New Parts
        </div>
        <!-- modal title -->

        <b-col lg="12">
          <!-- modal body -->
          <b-form @keydown="resetFieldStates('part')" autocomplete="off">
            <b-form-group>
              <label for="part_code">
                <i
                  class="icon-required fa fa-exclamation-circle"
                  data-toggle="tooltip"
                  data-placement="top"
                  title="Required Feild"
                ></i> Part Code
              </label>
              <b-form-input
                id="part_code"
                v-model="forms.part.fields.part_code"
                type="text"
                placeholder="Part Code"
                ref="part_code"
              ></b-form-input>
            </b-form-group>
            <b-form-group>
              <label>
                <i
                  class="icon-required fa fa-exclamation-circle"
                  data-toggle="tooltip"
                  data-placement="top"
                  title="Required Feild"
                ></i> Part Name
              </label>
              <b-form-input
                ref="part_name"
                id="part_name"
                v-model="forms.part.fields.part_name"
                type="text"
                placeholder="Part Name"
              ></b-form-input>
            </b-form-group>
            <b-form-group>
              <label>Part Desc</label>
              <b-form-input
                ref="part_desc"
                id="part_desc"
                v-model="forms.part.fields.part_desc"
                type="text"
                placeholder="Part Desc"
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
                v-model="forms.part.fields.department_id"
              >
                <option
                  v-for="right in options.departments.items"
                  :key="right.department_id"
                  :value="right.department_id"
                >{{right.department_name}}</option>
              </select2>
            </b-form-group>
          </b-form>
        </b-col>

        <!-- modal body -->

        <div slot="modal-footer">
          <!-- modal footer buttons -->
          <b-button :disabled="forms.part.isSaving" variant="primary" @click="onPartEntry">
            <icon v-if="forms.part.isSaving" name="sync" spin></icon>
            <i class="fa fa-check"></i>
            Save
          </b-button>
          <b-button variant="secondary" @click="showModalEntry=false">Close</b-button>
        </div>
        <!-- modal footer buttons -->
      </b-modal>
      <b-modal v-model="showModalDelete" :noCloseOnEsc="true" :noCloseOnBackdrop="true">
        <div slot="modal-title"></div>

        <b-col lg="12">Are you sure you want to Remove this kind of Part?</b-col>
        <div slot="modal-footer">
          <b-button :disabled="forms.part.isSaving" variant="primary" @click="onPartDelete">
            <icon v-if="forms.part.isSaving" name="sync" spin></icon>
            <i class="fa fa-check"></i>
            OK
          </b-button>
          <b-button variant="secondary" @click="showModalDelete=false">Close</b-button>
        </div>
      </b-modal>
    </div>
    <!-- modal div -->
  </div>
  <!-- main container -->
</template>
<script>
export default {
  name: "parts",
  data() {
    return {
      entryMode: "Add",
      showModalEntry: false, //if true show modal
      showModalDelete: false,
      forms: {
        part: {
          isSaving: false,
          isDeleting: false,
          fields: {
            part_id: null,
            part_code: null,
            part_name: null,
            part_desc: null,
            tech_id: 1
          }
        }
      },
      tables: {
        parts: {
          fields: [
            {
              key: "part_code",
              label: "Code",
              thStyle: { width: "150px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "part_name",
              label: "Part Name",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "part_desc",
              label: "Part Desc",
              tdClass: "align-middle",
              sortable: true
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
      filters: {
        parts: {
          criteria: null
        }
      },
      options: {
        departments: {
          items: []
        }
      },
      paginations: {
        parts: {
          totalRows: 0,
          currentPage: 1,
          perPage: 10
        }
      },
      part_id: null,
      row: []
    };
  },
  methods: {
    onPartEntry() {
      if (this.entryMode == "Add") {
        //name of form
        //if from a modal?
        //name of table to be inserted
        this.createEntity("part", true, "parts");
      } else {
        //name of form
        //name of primary key
        //if from a modal?
        //row to be edited
        this.updateEntity("part", "part_id", true, this.row);
      }
    },
    onPartDelete() {
      this.deleteEntity("part", this.part_id, true, "parts", "part_id");
    },
    async setDelete(data) {
      // if(await this.checkIfUsed('department', data.item.department_id) == true){
      //     this.$notify({
      //         type: 'error',
      //         group: 'notification',
      //         title: 'Error!',
      //         text: "Unable to delete, this record is being used by other transactions."
      //     })
      //     return
      // }
      this.part_id = data.item.part_id;
      this.showModalDelete = true;
    },
    setUpdate(data) {
      this.row = data.item;
      this.resetFieldStates("part");
      this.fillEntityForm("part", data.item.part_id);
      this.showModalEntry = true;
      this.entryMode = "Edit";
    }
  },
  created() {
    //name of table
    this.fillTableList("parts");
    this.fillOptionsList("departments");
  }
};
</script>

