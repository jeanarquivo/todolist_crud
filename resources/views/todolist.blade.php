<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
    <link rel="stylesheet" href ="{{ URL::asset('css/app.css') }}">
    <title>Document</title>
</head>
<body>
     <h1> Bem-vindo à sua ToDoList online!</h1>

     <div class="grid">
		<div class="item">
            <form>
			    <h2> New Task </h2> 
                <input type="text" id ="txtTask" placeholder = "Your task name..." />
                <br><br>
				<button class= "btn_edit" onclick ="saveTask()"> Save </button>
		</div>

		<div class="item">
			
			<h2> To Do List </h2>
			<table id ="todolist_table">
            <tr> <td>Id</td>  <td>Description</td> <td> </td> <td> </td></tr>
            <table>    
		</div>
     </div>   
     <script>
         
         $(document).ready(function(){

            $.get("/todolist_crud", function(data, status){
                 console.log("Data: " + JSON.stringify(data) + "\nStatus: " + status);
                 var table = document.getElementById("todolist_table");
                 if(data.length === 0)
                 {
                    var row = table.insertRow(0);
                    var cell1 = row.insertCell(0);
                    cell1.innerHTML = "No tasks yet!";
                 }else{
                   
                    for(let i =0; i < data.length; i++)
                    {
                        var row = table.insertRow(i+1);
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        cell1.innerHTML = data[i]["id"];
                        var id = data[i]["id"];
                        cell2.innerHTML = data[i]["name"];
                        var name = data[i]["name"];
                        cell3.innerHTML = "<button class = \"btn_edit\" onclick =\"openModal("+id+")\">Edit</button>";
                        cell4.innerHTML = "<button class = \"btn_delete\" onclick =\"deleteTask("+id+")\">Delete</button>";
                    }
                 }
            });
  
         });     
         function getTasks()
         {
            $.get("/todolist_crud", function(data, status){
                 console.log("Data: " + JSON.stringify(data) + "\nStatus: " + status);
                 var table = document.getElementById("todolist_table");
                 table.innerHTML = "";
                 var row = table.insertRow(0);
                 var cel1 = row.insertCell(0);
                 var cel2 = row.insertCell(1);
                 var cel3 = row.insertCell(2);
                 var cel4 = row.insertCell(3);
                 cel1.innerHTML = "Id";
                 cel2.innerHTML = "Description";
                 cel3.innerHTML = "";
                 cel4.innerHTML = "";
                        
                 if(data.length === 0)
                 {
                    var row = table.insertRow(0);
                    var cell1 = row.insertCell(0);
                    cell1.innerHTML = "No tasks yet!";
                 }else{
                   
                    for(let i =0; i < data.length; i++)
                    {
                        var row = table.insertRow(i+1);
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        var cell3 = row.insertCell(2);
                        var cell4 = row.insertCell(3);
                        cell1.innerHTML = data[i]["id"];
                        var id = data[i]["id"];
                        var name = data[i]["name"];
                        cell2.innerHTML = data[i]["name"];
                        cell3.innerHTML = "<button class = \"btn_edit\" onclick =\"openModal("+id+")\">Edit</button>";
                        cell4.innerHTML = "<button class = \"btn_delete\" onclick =\"deleteTask("+id+")\">Delete</button>";
                    }
                 }
            });
  

         }
         function saveTask()
         {
             let todo = document.getElementById("txtTask").value;
             if(todo.trim().length === 0)
             {
                 alert("Task name not found!");
             }else
             {
                $.post("/todolist_crud",
                    {
                        name: todo
                        
                    },
                    function(data, status){
                        console.log("Data: " +  JSON.stringify(data) + "\nStatus: " + status);
                    });
             }
         }

         function deleteTask(id)
         {
         //   alert("deleting " +id );
            $.ajax({
            url: '/todolist_crud/'+id,
            method: 'DELETE',
            contentType: 'application/json',
            success: function(result) {
                // handle success
                getTasks();
            },
            error: function(request,msg,error) {
                // handle failure
                alert("erro " +id );
            }
        });
    }

    function updateTask(id, taskName)
    {
        $.ajax({
            url: '/todolist_crud/'+id,
            type: 'PUT',
            data: 
            {
                name: taskName
            },
            success: function() {
                // handle success
                getTasks();
            },
            error: function(data) {
                // handle failure
                alert("Error editing the task: " +id );
            }
        });

    }
    function openModal(id)
    {
        let newTaskName = prompt("Please enter your new task name to task "+id, "New task Name");
        console.log("new task "+ newTaskName);
        if(newTaskName.trim().length === 0)
        {
            alert("It's not possible save a empty name for a task!");
        }else
        {
            updateTask(id, newTaskName);
        }    
    }
     </script>
</body>
</html>