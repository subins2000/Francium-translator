<?php
/**
 * An example of the usage of \Fr\Translator
 * This test translates English (en) to Malayalam (ml)
 */
?>
<!DOCTYPE html>
<html>
 	<head>
		
 	</head>
 	<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
      <label>
        <span>Text To Translate</span><br/>
        <textarea name="text"></textarea>
      </label>
      <label>
        <button>Translate !</button>
      </label>
      <?php
      if(isset($_POST['text'])){
        require "class.translator.php";
    
        $translated = \Fr\Translator::translate($_POST['text']);
        if($translated == null){
          echo "No Translation Available";
        }else{
      ?>
        <label>
          <span>Translated Text</span><br/>
          <textarea><?php echo $translated;?></textarea>
        </label>
      <?php
        }
      }
      ?>
    </form>
    <style>
      label{
        display: block;
        margin-bottom: 10px;
      }
    </style>
 	</body>
</html>
