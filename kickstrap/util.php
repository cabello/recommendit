<?php
function phone_mask($mask,$string)
{
   //$string = str_replace(" ","",$string);
   for($i=0;$i<strlen($string);$i++)
   {
      $mask[strpos($mask,"#")] = $string[$i];
   }
   return $mask;
}
?>