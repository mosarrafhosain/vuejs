<!DOCTYPE html>
<html>
  <head>
    <title>Vue JS Bangla Tutorial</title>
  </head>
  <body>
    
    <div id="root">
      <h1>Skills</h1><hr>
      <ul>
        <li v-for="(skill, i) in skills">
          {{ i+1 }}. {{ skill.name }} ({{ skill.experience }})
        </li>
      </ul>
    </div>
    
    <script type="text/javascript" src="vue.js"></script>
    <script type="text/javascript">
      var app = new Vue({
        el: "#root",
        data: {
          skills: [
            {name: "HTML", experience: 5},
            {name: "CSS", experience: 5},
            {name: "JS", experience: 4},
            {name: "php", experience: 3},
            {name: "java", experience: 6},
            {name: "nodejs", experience: 2}
          ]
        }
      });
    </script>
    
  </body>
</html>
