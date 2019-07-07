<!DOCTYPE html>
<html>
  <head>
    <title>Vue JS Bangla Tutorial</title>
    <style type="text/css">
      ul{
        list-style: none;
      }
      li{
        display: inline;
      }
      
      .active{
        background: #0C78A0;
        color: #FFFFFF;
        padding: 5px;
      }
    </style>
  </head>
  <body>
    
    <div id="root">
      <ul>
        <li>
          <a :class="{'active': activeLink == 'link1'}" :href="link1.url" :title="link1.title">{{ link1.text }}</a>
        </li>
        
        <li>
          <a :class="{'active': activeLink == 'link2'}" :href="link2.url" :title="link2.title">{{ link2.text }}</a>
        </li>
      </ul>
      
      <br><br><br>
      
      <p v-html="html">
      </p>
    </div>
    
    <script type="text/javascript" src="vue.js"></script>
    <script type="text/javascript">
      var app = new Vue({
        el: "#root",
        data: {
          link1: {
            text: "Facebook", title: "Go to facebook", url: "http://facebook.com"
          },

          link2: {
            text: "Youtube", title: "Go to youtube", url: "http://youtube.com"
          },
          
          activeLink: "link1",
          
          html: '<a href="http://mosarrafhosain.com"> About Me </a>'
        }
      });
    </script>
    
  </body>
</html>
