<!DOCTYPE html>
<html>
  <head>
    <title>Vue JS Bangla Tutorial</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    
    <div id="root">
      
      <panel title="This is title">
        <h1>Enter your name</h1>
        <input type="text" name="">
        <button>Submit</button>
      </panel>
    </div>
    
    <script type="text/javascript" src="vue.js"></script>
    <script type="text/javascript">
      Vue.component("panel", {
        template: `
        <div class="panel" v-if="show">
          <div class="panelTitle">
            <div class="close" @click="show = false">x</div>
            {{ title }}
          </div>
          <div class="panelContent">
            <slot></slot>
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
          
        }
      });
    </script>
    
  </body>
</html>
