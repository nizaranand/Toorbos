<?
require_once(".citadel.config.conf");
echo "Downloading Skins: ";
system('scp -r isitesoftware@ssh.isitesoftware.co.nz:./Expert-2.1/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/skins '.$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/.');
echo 'scp -r isitesoftware@ssh.isitesoftware.co.nz:./Expert-2.1/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/skins '.$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/.';
    echo "<b>Sucess</b><br>";

    echo "Downloading Repository files: ";
    system('scp -r isitesoftware@ssh.isitesoftware.co.nz:./Expert-2.1/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/files '.$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/.');
echo 'scp -r isitesoftware@ssh.isitesoftware.co.nz:./Expert-2.1/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/files '.$__CONFIG_['__paths_']['__installationPath_'].'/clients'.$__CONFIG_['__paths_']['__clientPath_'].'/.';
    echo "<b>Sucess</b><br>";
   
echo "<a href='creatSite.php'>Create site</a>"; 
	
?>
