<template>
  <div>
    <modal
      modalHeading="Add New Product"
      :cond="showingAddModal"
      @modalClose="showingAddModal = false"
    >
      <table>
        <tr>
          <td>Product Name</td>
          <td>
            <input type="text" id="newProName" v-model="newProduct.name" placeholder="Product Name" />
          </td>
        </tr>
        <tr>
          <td>Catetory</td>
          <td>
            <select v-model="newProduct.category">
              <option value>--Select One--</option>
              <option v-for="c in allCategories" :value="c.id">{{ c.name }}</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>Supplier</td>
          <td>
            <select v-model="newProduct.supplier">
              <option value>--Select One--</option>
              <option v-for="s in allSuppliers" :value="s.id">{{ s.name }}</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>Price</td>
          <td>
            <input type="text" v-model="newProduct.price" placeholder="Price" />
            &nbsp;
            <label>
              <input type="checkbox" v-model="newProduct.negotiable" /> Negotiable
            </label>
          </td>
        </tr>
        <tr>
          <td>Image</td>
          <td>
            <input type="file" id="image" @change="onfileChange" />
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <progress :value="percent" max="100" v-if="percent != 0 && percent != 100"></progress>
            <span v-if="percent != 0 && percent != 100">{{ percent }} %</span>
            <br />
            <br />
            <img
              :src="this.$apiBaseUrl + '/' + newProduct.image"
              alt="No image selected"
              class="thumbnail"
            />
          </td>
        </tr>
        <tr>
          <td>Product Description</td>
          <td>
            <textarea v-model="newProduct.description" placeholder="Write short description..."></textarea>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <button class="btnSave" @click="addNewProduct()">Save</button>
          </td>
        </tr>
      </table>
    </modal>

    <modal
      modalHeading="Update This Product"
      :cond="showingEditModal"
      @modalClose="showingEditModal = false"
    >
      <table>
        <tr>
          <td>Product Name</td>
          <td>
            <input
              type="text"
              id="editProName"
              v-model="clickedProduct.name"
              placeholder="Product Name"
            />
          </td>
        </tr>
        <tr>
          <td>Product Description</td>
          <td>
            <textarea v-model="clickedProduct.description" placeholder="Write short description..."></textarea>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <button class="btnSave" @click="updateProduct()">Update</button>
          </td>
        </tr>
      </table>
    </modal>

    <modal
      modalHeading="Are you sure?"
      :cond="showingDeleteModal"
      @modalClose="showingDeleteModal = false"
    >
      <h2>You are going to delete the product '{{ clickedProduct.name }}'</h2>

      <table>
        <tr>
          <td>
            <button class="btnSave" @click="deleteProduct()">Yes</button>
          </td>
          <td>
            <button class="btnClose" @click="showingDeleteModal = false">No</button>
          </td>
        </tr>
      </table>
    </modal>

    <h2 class="fleft">Products</h2>
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
      <tr v-for="product in products">
        <td>{{ product.id }}</td>
        <td>{{ product.name }}</td>
        <td>{{ product.description }}</td>
        <td>
          <button class="edit" @click="showingEditModal = true; clickedProduct = product">Edit</button>
        </td>
        <td>
          <button class="delete" @click="showingDeleteModal = true; clickedProduct = product">Delete</button>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  name: "Product",
  data() {
    return {
      showingAddModal: false,
      showingEditModal: false,
      showingDeleteModal: false,

      newProduct: {
        name: "",
        description: "",
        supplier: "",
        category: "",
        price: 0,
        negotiable: true,
        image: "img/uploads/default.jpg"
      },
      clickedProduct: {},
      allCategories: [],
      allSuppliers: [],
      products: [],
      percent: 0
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.$eventBus.$emit("loadingStatus", true);

      this.$axios.get(this.$apiBaseUrl + "/get-categories").then(res => {
        this.$eventBus.$emit("loadingStatus", false);

        if (res.data.error) {
          this.$iziToast.error({
            title: "Error",
            message: res.data.message
          });
        } else {
          this.allCategories = res.data.categories;
        }
      });

      this.$axios.get(this.$apiBaseUrl + "/get-suppliers").then(res => {
        this.$eventBus.$emit("loadingStatus", false);

        if (res.data.error) {
          this.$iziToast.error({
            title: "Error",
            message: res.data.message
          });
        } else {
          this.allSuppliers = res.data.suppliers;
        }
      });

      this.$axios.get(this.$apiBaseUrl + "/get-products").then(res => {
        this.$eventBus.$emit("loadingStatus", false);

        if (res.data.error) {
          this.$iziToast.error({
            title: "Error",
            message: res.data.message
          });
        } else {
          this.products = res.data.products;
        }
      });
    },

    onfileChange(e) {
      var _this = this;
      var files = e.target.files || e.dataTransfers.files;

      var file = files[0];

      var fd = new FormData();
      fd.append("fileToUpload", file, file.name);

      this.$axios
        .post(this.$apiBaseUrl + "/upload-image", fd, {
          onUploadProgress: function(uploadEvent) {
            _this.percent = Math.round(
              (uploadEvent.loaded / uploadEvent.total) * 100
            );
          }
        })
        .then(res => {
          _this.newProduct.image = res.data.uploadedUrl;
        });
    },

    addNewProduct() {
      // console.log(this.newProduct);

      if (!this.newProduct.name) {
        this.$iziToast.error({
          title: "Error",
          message: "Product name can not be empty!"
        });

        var proNameInput = document.getElementById("newProName");
        proNameInput.focus();

        return;
      }

      this.$eventBus.$emit("loadingStatus", true);

      this.$axios
        .post(this.$apiBaseUrl + "/add-product", this.newProduct)
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

    updateProduct() {
      // console.log(this.clickedProduct);

      if (!this.clickedProduct.name) {
        this.$iziToast.error({
          title: "Error",
          message: "Product name can not be empty!"
        });

        var proNameInput = document.getElementById("editProName");
        proNameInput.focus();

        return;
      }

      this.$eventBus.$emit("loadingStatus", true);

      this.$axios
        .post(this.$apiBaseUrl + "/update-product", this.clickedProduct)
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

            this.clickedProduct = {};
            this.init();
          }
        });
    },

    deleteProduct() {
      // console.log(this.clickedProduct);
      this.$eventBus.$emit("loadingStatus", true);

      this.$axios
        .post(this.$apiBaseUrl + "/delete-product", this.clickedProduct)
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

            this.clickedProduct = {};
            this.init();
          }
        });
    }
  }
};
</script>
