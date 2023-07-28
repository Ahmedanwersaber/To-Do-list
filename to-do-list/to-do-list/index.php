<?php
require 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<div class="main-section">
<div class="add-section">
    <form action="app/add.php" method="POST" autocomplete="off">
        <?php if(isset($_GET['mess'])&& $_GET['mess'] == 'error'){ ?>
            <input type="text" name="title" placeholder="this faild is required"
            style="border-color:#ff6666"><br>
<button type="submit">Add &nbsp; <span>&#43;</span></button>
            <?php }else{ ?>
        <input type="text" name="title" placeholder="what do you need to do ?"><br>
        <button type="submit">Add &nbsp; <span>&#43;</span></button>
        <?php  } ?>
    </form>
</div>
<?php
$todos=$conn->query("SELECT * FROM todo ORDER BY id DESC");

?>
<div class="show-todo-section">
<?php 
if($todos->rowCount() <= 0 ){?>
<div class="todo-item">
<div class="empty">
<img src="img/f.jpg" width="100%" height="350px">
<img src="img/elipsis.gif" width="88px">
</div>
    </div>
<?php  } ?>

<?php while($todo= $todos->fetch(PDO::FETCH_ASSOC)) {?>
    <div class="todo-item">
        <span id="<?php echo $todo['id']; ?>"
        class="remove-to-do">x</span>
        <?php if($todo['checked']){ ?>
     <input type="checkbox" class="check-box" checked />
    <h2 class="checked"><?php echo $todo['title'] ?></h2>
        <?php }else{ ?> 
            <input type="checkbox" class="check-box"  />
    <h2 ><?php echo $todo['title'] ?></h2>
    <?php } ?>
        <br>
    <small>created:<?php echo $todo['date_time'] ?></small>
           
    </div>

<?php } ?>

</div>
</div>
<script src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.remove-to-do').click(function(){
            const id=$(this).attr('id');
            $.post("app/remove.php",{
                id: id
            },
            (data)=>{
                if(data){
                    $(this).parent().hide(600);
                }
            });
        })
        
    })
</script>
</body>
</html>
