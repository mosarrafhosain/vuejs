<!DOCTYPE html>
<html>
  <head>
    <title>Vue JS Bangla Tutorial</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    
    <div id="root">
      <button @click="showLogin = true">Login</button>
      
      <modal v-if="showLogin" @onsave="showLogin = false">
        <template slot="header">
          This is modal header
        </template>
        
        <template slot="body">
          <h1>Enter your name</h1>
          <input type="text" name="">
        </template>
      </modal>
      
    </div>
    
    <script type="text/javascript" src="vue.js"></script>
    <script type="text/javascript">
      Vue.component("modal", {
        template: `
        <div class="modal" v-if="show">
          <div class="modalContent">
            <div class="modalHeader">
              <slot name="header"></slot>
            </div>
                  
            <div class="modalBody">
              <slot name="body"></slot>
            </div>
                  
            <div class="modalFooter">
              <button @click="$emit('onsave')">Save</button>
              <button>Cancel</button>
            </div>
          </div>
        </div>
        `,
        
        props: ["title", "content"],
        data: function(){
          return {
            show: true
          }
        }
      });
      
      var app = new Vue({
        el: "#root",
        data: {
          showLogin: false
        }
      });
    </script>
    
  </body>
</html>
