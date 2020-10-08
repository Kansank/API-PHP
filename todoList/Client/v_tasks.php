<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TodoList</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    
    <style>
        html{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family:Arial, Helvetica, sans-serif
        }

        th{
            color: white;
            background-color: #4CAF50;
            
        }
        .container{
            margin: 20px
        }
        input[type=submit]:hover {
            background-color: #45a049;
        }

        .addtask{
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
            margin-bottom:50px;
            width:50%;
            margin:auto;
            
        }
        input[type=text]{
        
            padding: 12px 12px 12px 12px;
            margin: 8px 8px ;
            border: 1px solid #ccc;
            border-radius: 4px;
            display: inline-block;
            width:80%
        
        }
        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 14px 20px;
            cursor: pointer;
            display: inline-block;
        }
        .table{
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding:5px;
            width:80%;
            margin:25px auto auto auto;
        }
        
        .remove{
            background:red;
            color:#fff;
            cursor: pointer;
            border-radius: 4px;
            border: 1px solid #ccc;
            padding:5px 12px 5px 12px;
            cursor: pointer;
        }

        .line-through{
            text-decoration : line-through;
        }
        @media screen and (max-width: 1024px) {
            input[type=submit],input[type=text] {
                width:100%;
                margin: .5rem auto;
            }    
            
        }

    </style>
</head>
<body>
    <div class="container">
                <div class="addtask">
                    <form >
                    <label for="task">Task</label>
                        <input type="text" name="task_name" id=task_add"" placeholder="Input task"> 
                        <input type="submit" value="Submit" >
                    </form>
                    
                </div>
                <div class="table">
                    
                    <table id="table_id" class="display">
                        <thead>
                            <tr>
                                <th width="10%" >No.</th>
                                <th>Task</th>
                                <th width="10%">Remove</th>
                            </tr>
                        </thead>
                        <tbody id="tasks_row">
                            
                        </tbody>
                    </table>
                </div>
       
    </div>
    
    <script>
        $(document).ready( function () {
            
            getApitask(); 
            function getApitask(){               
                 //get all tasks
                $.get("http://localhost/todoList/TaskAll.php", function(data, status){
                    
                    console.log(data);
                    let row;
                    let no = 1;
                    $('#tasks_row').empty();
                    $.each(data, function(i, item) {
                        if(data[i].status==1){ 
                            row += `<tr>
                                        <td > ${no} </td>
                                        
                                        <td class="line-through " id="${data[i].taskID}"> ${data[i].name} </td>


                                        <td style="text-align:center">
                                        <button  class="remove" value="${data[i].taskID}"   ><i class="material-icons">delete</i></button>
                                        
                                        </td>
                                    </tr>`;  no++

                        }else{ row += `<tr>
                                        <td> ${no} </td>
                                        
                                        <td id="${data[i].taskID}" class="changeStatus"> ${data[i].name} </td>


                                        <td style="text-align:center">
                                        <button  class="remove" value="${data[i].taskID}"   ><i class="material-icons">delete</i></button>
                                        
                                        </td>
                                    </tr>`;  no++ }

                                
                    
                    });
                    
                    $('#tasks_row').html(row);
                    $('#table_id').DataTable({ 
                        "destroy": true, //use for reinitialize datatable
                    });
                    
                });


            }
           
               
             // Task finished update
             $(document).on('click', '.changeStatus', function (event) {

                let taskID = $(this).closest('tr').find(".remove").val(); 

                $(this).parent().find(".changeStatus").css('text-decoration', 'line-through');

                const updateTask ="updateTask";
                $.ajax({
                    type: "POST", //PUT
                    url: "http://localhost/todoList/TaskUpdate.php",
                    data: {
                        "taskID" : taskID,
                        "updateTask" : updateTask
                    },
                    success : function(data){
                        console.log(data);
                        
                    }
                });

                
             });


             // Insert task
             $("form").submit(function(){
        
                 $.ajax({
                    type: "POST",
                    url: "http://localhost/todoList/TaskAdd.php",
                    data: {
                        "task_name" : $("input:text").val()
                    },
                    success : function(data){
                        console.log(data);
                        
                    }
                });


             });

             $(document).on('click', '.remove', function (event) {
                 
                let taskID = $(this).val(); 
                console.log(taskID)
                const deleteTask = "deleteTask";
                
                $.ajax({
                    type: "POST", //DELETE
                    url: "http://localhost/todoList/TaskDelete.php",
                    data: {
                        "taskID" : taskID,
                        "deleteTask" : deleteTask
                        
                    },
                    
                    success: function (data) { 
                        console.log(data);
                        
                        location.reload();
                    }
                    

                });
                         
                                    
                
             });

             
        } );
    </script>
</body>
</html>