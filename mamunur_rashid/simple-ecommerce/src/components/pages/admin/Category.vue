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
    <h2 class="fleft">Categories</h2>
    <button class="addBtn fright" @click="showingAddModal = true">Add New</button>
    <div class="clear"></div>
    <hr />
  </div>
</template>

<script>
export default {
  name: "Category",
  data() {
    return {
      showingAddModal: false,
      newCategory: {
        name: "",
        description: ""
      }
    };
  },
  methods: {
    addNewCategory() {
      // console.log(this.newCategory);
      this.$eventBus.$emit("loadingStatus", true);

      this.$axios
        .post(
          "http://localhost:8081/mhs/vuejs/rimonbd/simple-ecommerce/api/public/add-category",
          this.newCategory
        )
        .then(res => {
          this.$eventBus.$emit("loadingStatus", false);
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
          }
        });
    }
  }
};
</script>
