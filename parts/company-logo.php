<?php 
  $global_fields = get_fields('option');
?> 

<a href="/">
  <div class="logo">
    <?php 
      $logo_content = file_get_contents($global_fields['company_logo']['url']);
      print $logo_content;
    ?>
  </div>
</a>
