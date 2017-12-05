<?php


$file = 'https://github.com/t-franz/Drupal-helper-files/archive/master.zip';



if (file_put_contents("master.zip", file_get_contents($file)) ) {
    echo 'File "'.$file.'" geladen.<br/>';
    unzip("master.zip");
    movefiles();
    unlink("master.zip");
    print '<br/><br/>Next Step: <b><a href="_helper.php#downloadcore">_helper.php</a></b>';
} else {
    echo 'Herunterladen von "'.$file.'" fehlgeschlagen.<br/>';
}


function unzip($file){ 
    $zip = zip_open($file);
    if ($zip) {echo "Open zip file\n"; } else{ 
        echo "Unable to open zip file\n"; 
    }  
    if(is_resource($zip)){ 
        echo "<br>ZIP is_resource<br>\n";
        $tree = ""; 
        while(($zip_entry = zip_read($zip)) !== false){ 
            if(strpos(zip_entry_name($zip_entry), DIRECTORY_SEPARATOR) !== false){ 
                $last = strrpos(zip_entry_name($zip_entry), DIRECTORY_SEPARATOR); 
                $dir = substr(zip_entry_name($zip_entry), 0, $last); 
                $file = substr(zip_entry_name($zip_entry), strrpos(zip_entry_name($zip_entry), DIRECTORY_SEPARATOR)+1); 
                if(!is_dir($dir)){ 
                    @mkdir($dir, 0755, true) or die("Unable to create $dir\n"); 
                } 
                if(strlen(trim($file)) > 0){ 
                    $return = @file_put_contents($dir."/".$file, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry))); 
                    if($return === false){ 
                        die("Unable to write file $dir/$file\n"); 
                    } 
                } 
            }else{ 
                if (file_put_contents($file, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry))) ) {
                		echo "Sites entpacken\n"; 
                	} else {
                		echo "Entpacken fehlgeschlagen\n";
                }
                	 
            } 
        } 
    }
    
} 



function movefiles() {
    echo '<br/>Move files:<br/>';
    // Get array of all source files
    $files = scandir("Drupal-helper-files-master");
    // Identify directories
    $source = "Drupal-helper-files-master/";
    $destination = "";
    // Cycle through all source files
    foreach ($files as $file) {
      //echo '<br/>Found file <i>'.$file.'</i> ... ';
      if (in_array($file, array(".",".."))) continue;
      echo '<br/>Copy <i>'.$source.$file.'</i> to <i>'.$destination.$file.'</i> ...';
      // If we copied this successfully, mark it for deletion
      if (copy($source.$file, $destination.$file)) {
        $delete[] = $source.$file;
      }
    }
    // Delete all successfully-copied files
    foreach ($delete as $file) {
      echo '<br/>Unlink file <i>'.$file.'</i> ...';
      unlink($file);
    }
    unlink($destination.'.gitattributes');
    rmdir("Drupal-helper-files-master");
}
