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
          <p>
            {{ skill }} <button @click="removeSkill(i)">x</button>
          </p>
        </li>
      </ul>
      
      <input type="text" v-model="newSkill">
      <button @click="addNewSkill()">Add</button>
    </div>
    
    <script type="text/javascript" src="vue.js"></script>
    <script type="text/javascript">
      var app = new Vue({
        el: "#root",
        data: {
          newSkill: "",
          skills: ["HTML", "CSS", "JS"]
        },
        methods: {
          addNewSkill: function(){
            this.skills.push(this.newSkill);
            this.newSkill = '';
          },
          
          removeSkill: function(i){
            this.skills.splice(i, 1);
          }
        }
      });
    </script>
    
  </body>
</html>
