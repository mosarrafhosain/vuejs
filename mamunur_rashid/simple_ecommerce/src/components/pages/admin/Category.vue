<template>
  <div>
    <modal
      modalHeading="Add New Category"
      :cond="showingAddModal"
      @modalClose="showingAddModal = false"
    >
      <table>
        <tr>
          <td>Category Name</td>
          <td>
            <input
              type="text"
              id="newCatName"
              v-model="newCategory.name"
              placeholder="Category Name"
            />
          </td>
        </tr>
        <tr>
          <td>Category Description</td>
          <td>
            <textarea v-model="newCategory.description" placeholder="Write short description..."></textarea>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <button class="btnSave" @click="addNewCategory()">Save</button>
          </td>
        </tr>
      </table>
    </modal>

    <modal
      modalHeading="Update This Category"
      :cond="showingEditModal"
      @modalClose="showingEditModal = false"
    >
      <table>
        <tr>
          <td>Category Name</td>
          <td>
            <input
              type="text"
              id="editCatName"
              v-model="clickedCategory.name"
              placeholder="Category Name"
            />
          </td>
        </tr>
        <tr>
          <td>Category Description</td>
          <td>
            <textarea
              v-model="clickedCategory.description"
              placeholder="Write short description..."
            ></textarea>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
            <button class="btnSave" @click="updateCategory()">Update</button>
          </td>
        </tr>
      </table>
    </modal>

    <modal
      modalHeading="Are you sure?"
      :cond="showingDeleteModal"
      @modalClose="showingDeleteModal = false"
    >
      <h2>You are going to delete the category '{{ clickedCategory.name }}'</h2>

      <table>
        <tr>
          <td>
            <button class="btnSave" @click="deleteCategory()">Yes</button>
          </td>
          <td>
            <button class="btnClose" @click="showingDeleteModal = false">No</button>
          </td>
        </tr>
      </table>
    </modal>

    <h2 class="fleft">Categories</h2>
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
      <tr v-for="category in categories">
        <td>{{ category.id }}</td>
        <td>{{ category.name }}</td>
        <td>{{ category.description }}</td>
        <td>
          <button class="edit" @click="showingEditModal = true; clickedCategory = category">Edit</button>
        </td>
        <td>
          <button
            class="delete"
            @click="showingDeleteModal = true; clickedCategory = category"
          >Delete</button>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  name: "Category",
  data() {
    return {
      showingAddModal: false,
      showingEditModal: false,
      showingDeleteModal: false,

      newCategory: {
        name: "",
        description: ""
      },
      clickedCategory: {},
      categories: []
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
          this.categories = res.data.categories;
        }
      });
    },

    addNewCategory() {
      // console.log(this.newCategory);

      if (!this.newCategory.name) {
        this.$iziToast.error({
          title: "Error",
          message: "Category name can not be empty!"
        });

        var catNameInput = document.getElementById("newCatName");
        catNameInput.focus();

        return;
      }

      this.$eventBus.$emit("loadingStatus", true);

      this.$axios
        .post(this.$apiBaseUrl + "/add-category", this.newCategory)
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

    updateCategory() {
      // console.log(this.clickedCategory);

      if (!this.clickedCategory.name) {
        this.$iziToast.error({
          title: "Error",
          message: "Category name can not be empty!"
        });

        var catNameInput = document.getElementById("editCatName");
        catNameInput.focus();

        return;
      }

      this.$eventBus.$emit("loadingStatus", true);

      this.$axios
        .post(this.$apiBaseUrl + "/update-category", this.clickedCategory)
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

            this.clickedCategory = {};
            this.init();
          }
        });
    },

    deleteCategory() {
      // console.log(this.clickedCategory);
      this.$eventBus.$emit("loadingStatus", true);

      this.$axios
        .post(this.$apiBaseUrl + "/delete-category", this.clickedCategory)
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

            this.clickedCategory = {};
            this.init();
          }
        });
    }
  }
};
</script>
