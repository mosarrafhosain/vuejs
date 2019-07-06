<!DOCTYPE html>
<html>
  <head>
    <title>Vue JS Bangla Tutorial</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    
    <div id="root">
      
      <tabs>
        <tab name="Tab1" selected="true">
          Tab1 content... <button>btn1</button>
        </tab>
        
        <tab name="Tab2">
          Tab2 content...
        </tab>
        
        <tab name="Tab3">
          Tab3 content...
        </tab>
        
        <tab name="Tab4">
          Tab4 content...
        </tab>
        
        <tab name="Tab5">
          Tab5 content...
        </tab>
      </tabs>
      
    </div>
    
    <script type="text/javascript" src="vue.js"></script>
    <script type="text/javascript" src="components.js"></script>
    
    <script type="text/javascript">
      
      var app = new Vue({
        el: "#root",
        data: {
          showLogin: false
        }
      });
      
    </script>
    
  </body>
</html>
