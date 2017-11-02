<?php

$nofile = TRUE;
$version = 70;


while ($nofile && $version > 50) {
	$file = 'https://ftp.drupal.org/files/projects/drupal-7.'.$version.'.zip';
	print 'Checkfile: '.$file.'<br/>';
	if (strlen(file_get_contents($file))) {
		$nofile = FALSE;
		print '<br/>Get file: '.$file.'<br/>';
	} else {
		$version--;
	}
}



if (file_put_contents("drupal_core.zip", file_get_contents($file)) ) {
    echo 'File "'.$file.'" geladen.<br/>';
    unzip("drupal_core.zip");
    unlink("drupal_core.zip");
    if (!rename('drupal-7.'.$version,'drupal')) {
        print '<br/><br/>Could not rename folder <em>drupal-7.'.$version.'</em>. <b>Please rename folder <em>drupal-7.'.$version.'</em> manually.</b><br/>';
    } else {
        print '<br/>Renaming folder <em>drupal-7.'.$version.'</em> to <em>drupal</em><br/>';
    }
    print '<br/><a href="http://sandbox.fusbfg.de/admin/reports/updates/update" target="_blank">http://sandbox.fusbfg.de/admin/reports/updates/update</a><br/>';
    print '<br/><a href="http://sandbox.fusbfg.de/admin/config/regional/translate/check" target="_blank">http://sandbox.fusbfg.de/admin/config/regional/translate/check</a><br/>';
    print '<br/><a href="http://sandbox.fusbfg.de/admin/config/content/ckeditor/editg#edit-skin" target="_blank">http://sandbox.fusbfg.de/admin/config/content/ckeditor/editg</a>: <a href="http://ckeditor.com/download" target="_blank">CKEditor-Version</a>, <a href="https://github.com/jackmoore/colorbox#changelog" target="_blank">Colorbox</a>, <a href="https://github.com/woothemes/FlexSlider#updates" target="_blank">Flexslider</a> und Libraries überprüfen';
    print '<br/><a href="http://sandbox.fusbfg.de/admin/config/system/backup_migrate" target="_blank">Sandbox Backup erstellen</a><br/>';

    print '<br/><br/>Create <em>sites.zip</em>: <a href="http://sandbox.fusbfg.de/_zip.php?dir=sites" target="_blank">http://sandbox.fusbfg.de/_zip.php?dir=sites</a>';
    print '<br/>Next Step: <b><a href="_download_sites.php">_download_sites.php</a>';
} else {
    echo 'Herunterladen von "'.$file.'" fehlgeschlagen.<br/>';
}


function unzip($file){ 
    $zip = zip_open($file); 
    if(is_resource($zip)){ 
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
                		echo "Drupal Core entpacken\n"; 
                	} else {
                		echo "Entpacken fehlgeschlagen\n";
                }
                	 
            } 
        } 
    }else{ 
        echo "Unable to open zip file\n"; 
    } 
} 

