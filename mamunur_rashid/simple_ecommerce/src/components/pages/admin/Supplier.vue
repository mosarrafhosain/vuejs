<template>
  <div>
    <modal
      modalHeading="Add New Supplier"
      :cond="showingAddModal"
      @modalClose="showingAddModal = false"
    >
      <table>
        <tr>
          <td>Supplier Name</td>
          <td>
            <input
              type="text"
              id="newSupName"
              v-model="newSupplier.name"
              placeholder="Supplier Name"
            />
          </td>
        </tr>
        <tr>
          <td>Supplier Description</td>
          <td>
            <textarea v-model="newSupplier.description" placeholder="Write short description..."></textarea>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <button class="btnSave" @click="addNewSupplier()">Save</button>
          </td>
        </tr>
      </table>
    </modal>

    <modal
      modalHeading="Update This Supplier"
      :cond="showingEditModal"
      @modalClose="showingEditModal = false"
    >
      <table>
        <tr>
          <td>Supplier Name</td>
          <td>
            <input
              type="text"
              id="editSupName"
              v-model="clickedSupplier.name"
              placeholder="Supplier Name"
            />
          </td>
        </tr>
        <tr>
          <td>Supplier Description</td>
          <td>
            <textarea
              v-model="clickedSupplier.description"
              placeholder="Write short description..."
            ></textarea>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <button class="btnSave" @click="updateSupplier()">Update</button>
          </td>
        </tr>
      </table>
    </modal>

    <modal
      modalHeading="Are you sure?"
      :cond="showingDeleteModal"
      @modalClose="showingDeleteModal = false"
    >
      <h2>You are going to delete the supplier '{{ clickedSupplier.name }}'</h2>

      <table>
        <tr>
          <td>
            <button class="btnSave" @click="deleteSupplier()">Yes</button>
          </td>
          <td>
            <button class="btnClose" @click="showingDeleteModal = false">No</button>
          </td>
        </tr>
      </table>
    </modal>

    <h2 class="fleft">Suppliers</h2>
    <button class="addBtn fright" @click="showingAddModal = true">Add New</button>
    <div class="clear"></div>
    <hr />

    <table class="nice-table">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
      <tr v-for="supplier in suppliers">
        <td>{{ supplier.id }}</td>
        <td>{{ supplier.name }}</td>
        <td>{{ supplier.description }}</td>
        <td>
          <button class="edit" @click="showingEditModal = true; clickedSupplier = supplier">Edit</button>
        </td>
        <td>
          <button
            class="delete"
            @click="showingDeleteModal = true; clickedSupplier = supplier"
          >Delete</button>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  name: "Supplier",
  data() {
    return {
      showingAddModal: false,
      showingEditModal: false,
      showingDeleteModal: false,

      newSupplier: {
        name: "",
        description: ""
      },
      clickedSupplier: {},
      suppliers: []
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.$eventBus.$emit("loadingStatus", true);

      this.$axios.get(this.$apiBaseUrl + "/get-suppliers").then(res => {
        this.$eventBus.$emit("loadingStatus", false);

        if (res.data.error) {
          this.$iziToast.error({
            title: "Error",
            message: res.data.message
          });
        } else {
          this.suppliers = res.data.suppliers;
        }
      });
    },

    addNewSupplier() {
      // console.log(this.newSupplier);

      if (!this.newSupplier.name) {
        this.$iziToast.error({
          title: "Error",
          message: "Supplier name can not be empty!"
        });

        var supNameInput = document.getElementById("newSupName");
        supNameInput.focus();

        return;
      }

      this.$eventBus.$emit("loadingStatus", true);

      this.$axios
        .post(this.$apiBaseUrl + "/add-supplier", this.newSupplier)
        .then(res => {
          this.$eventBus.$emit("loadingStatus", false);
          this.showingAddModal = false;

          if (res.data.error) {
            this.$iziToast.error({
              title: "Error",
              message: res.data.message
            });
          } else {
            this.$iziToast.success({
              title: "Success",
              message: res.data.message
            });
            this.init();
          }
        });
    },

    updateSupplier() {
      // console.log(this.clickedSupplier);

      if (!this.clickedSupplier.name) {
        this.$iziToast.error({
          title: "Error",
          message: "Supplier name can not be empty!"
        });

        var supNameInput = document.getElementById("editSupName");
        supNameInput.focus();

        return;
      }

      this.$eventBus.$emit("loadingStatus", true);

      this.$axios
        .post(this.$apiBaseUrl + "/update-supplier", this.clickedSupplier)
        .then(res => {
          this.$eventBus.$emit("loadingStatus", false);
          this.showingEditModal = false;

          if (res.data.error) {
            this.$iziToast.error({
              title: "Error",
              message: res.data.message
            });
          } else {
            this.$iziToast.success({
              title: "Success",
              message: res.data.message
            });

            this.clickedSupplier = {};
            this.init();
          }
        });
    },

    deleteSupplier() {
      // console.log(this.clickedSupplier);
      this.$eventBus.$emit("loadingStatus", true);

      this.$axios
        .post(this.$apiBaseUrl + "/delete-supplier", this.clickedSupplier)
        .then(res => {
          this.$eventBus.$emit("loadingStatus", false);
          this.showingDeleteModal = false;

          if (res.data.error) {
            this.$iziToast.error({
              title: "Error",
              message: res.data.message
            });
          } else {
            this.$iziToast.success({
              title: "Success",
              message: res.data.message
            });

            this.clickedSupplier = {};
            this.init();
          }
        });
    }
  }
};
</script>
