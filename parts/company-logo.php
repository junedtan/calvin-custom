<?php 
  $global_fields = get_fields('option');
?> 

<a href="/">
  <div class="logo">
    <?php 
      $logo_url = $global_fields['company_logo']['url'];
      if (str_ends_with($logo_url, 'svg')) {
        $logo_url = str_replace(get_option('siteurl'),ABSPATH,$logo_url);
        $logo_url = str_replace('//','/',$logo_url);
        $logo_content = file_get_contents($logo_url);
        print $logo_content;  
      } else {
        // assume jpg or png
        print '<img src="'.$global_fields['company_logo']['url'].'" alt="LOGO" />';
      }
    ?>
  </div>
</a>
