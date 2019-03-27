param($computer="")

$Username = 'myadmin@mydomain.com'
$Password = 'myPerfectPassword'
$domain = 'mydomain.com'
$apipath = 'C:\inetpub\wwwroot\api\apps\'
$pass = ConvertTo-SecureString -AsPlainText $Password -Force
$Cred = New-Object System.Management.Automation.PSCredential -ArgumentList $Username,$pass
$computer = $computer + "." + $domain;
$g = New-PSSession -ComputerName $computer -Credential $Cred
$file = Get-Content $apipath + 'TaskManager.js' -Force 
#| foreach-object {$file += $_}
Invoke-Command -Session $g -ScriptBlock {Set-Content -Path 'C:\Program Files (x86)\Powerstack\TaskManager.js' -Value $using:file}
Invoke-Command -Session $g -ScriptBlock {Restart-Service -ServiceName 'Powerstack Task Manager'}
Invoke-Command -Session $g -ScriptBlock {Restart-Service -ServiceName 'Powerstack Web API'}

exit
